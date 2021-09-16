<?php

namespace App\Exports;

use App\Models\Orders\BuyOrder;
use App\Models\Products\Product;
use App\Models\Users\Customer;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


class BuyOrdersExport extends DefaultValueBinder implements FromQuery ,WithHeadings ,WithCustomValueBinder,ShouldAutoSize, WithMapping,WithColumnWidths
{
    use Exportable;

    public $customer_id;

    public function __construct()
    {
    }

    public function columnWidths(): array
    {
        return [
            'D' => 55,   
            'E' => 30,
            'H' => 50,
        ];
    }

    public function query()
    {
        /*return BuyOrder::query()->whereIn('id', $this->orders)->select('delivery_date' , 'bar_code' , 'customer_id', 'price' , 'user_id');*/
        return BuyOrder::query()->with(['customer','buyOrderProducts'])->where(function($query){

            if(request()->filled('employee_id'))
            {
                $query->where('created_by' , request()->employee_id);
            }

            if(request()->filled('confirmation'))
            {
                $query->where('confirmation' , request()->confirmation);
            }

            if(request()->filled('from'))
            {
                $query->where('delivery_date' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->where('delivery_date' , '<=' , request()->to);  
            }

            if(request()->filled('shipping_company_id'))
            {
                $query->where('shipping_company_id' , request()->shipping_company_id);
            }


        })->select('id' , 'delivery_date' , /*'bar_code',*/ 'order_number' , 'customer_id' , 'price' , 'shipping_fees' , 'description');
    }

    public function map($order): array
    {
        $res = '';
        $total = 0;
        foreach($order->buyOrderProducts as $buy_product)
        {
            $product = Product::with('material:id,mq_r_code' , 'size:id,name')->where('produce_code' , $buy_product->produce_code)->first();
            if($product)
            {
                //$res = $res . ' - [ $product->material->mq_r_code ] - [] '
                $res = $res . ' - ' . '[' .  $product->material->mq_r_code . '] [' . ($buy_product->company_qty + $buy_product->factory_qty) . '] [' . $product->size->name . ']' ; 
            }
            $total += $buy_product->company_qty + $buy_product->factory_qty;
        }
        return [
            $order->delivery_date,
            //$order->bar_code,
            $order->order_number,
            $order->customer->name,
            $order->customer->address,
            $order->customer->phone,
            $order->price,
            $order->shipping_fees,
            $order->net,
            $order->description,
            $res,
            $total,
        ];
    }

    public function headings(): array
    {
        return [
            'Date In' ,
            //'AWB' ,
            'AWB' ,
            'Name' ,
            'Address' ,
            'Mobile' ,
            'Cash' ,
            'Shipping Fees' ,
            'Net',
            'Notes' ,
            'Products' ,
            'N. pieces'
        ];
        /*return [
            'Date In' ,
            'AWB' ,
            'Name' ,
            /*'Address' ,
            'Mobile' ,
            'Cash' ,
            'Notes' ,
            /*'Products' ,
            'N. Pieses' ,
        ];*/
    }
    /*public function bindValue(Cell $cell, $value)
    {
        if($cell->getColumn() == 'C')
        {
            $customer = Customer::where('id' , $value)->first();
            if($customer)
            {
                $this->customer_id = $value;
                return parent::bindValue($cell , $customer->name);
            }
            return parent::bindValue($cell, $value);
        }

        if($cell->getColumn() == 'D')
        {
            return parent::bindValue($cell , 'hiii');
            $customer = Customer::where('id' , $this->customer_id)->first();
            if($customer)
            {
                return parent::bindValue($cell , $customer->address);
            }
            return parent::bindValue($cell, $value);
        }

        return parent::bindValue($cell, $value);

    }*/
}
