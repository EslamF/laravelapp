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
use Illuminate\Support\Facades\DB;


class ProductsExport extends DefaultValueBinder implements FromQuery ,WithHeadings ,WithCustomValueBinder,ShouldAutoSize, WithMapping,WithColumnWidths
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
        if(request()->has('about_to_run_products'))
        {
            return  Product::where('status' , 'available')
                            ->with('productType:id,name', 'size:id,name' , 'material:id,mq_r_code')
                            ->select('id' , 'produce_code' , 'material_id' , 'product_type_id' , 'size_id' , 'status' , DB::raw('count(*) as total'))
                            ->orderBy('material_id')
                            ->orderBy('product_type_id')
                            ->groupBy('produce_code')
                            ->havingRaw('COUNT(*) <= ?', [5]);
        }
        else if(request()->has('low_sale_products'))
        {
            $NewDate = date('Y-m-d', strtotime('-30 days'));

            return  Product::whereHas('buyOrders' , function($query) use($NewDate) {
                                $query->where('buy_orders.created_at', '<=', $NewDate);
                                })
                            ->orWhereDoesntHave('buyOrders')
                            //->get()
                            ->groupBy('product_material_code');
        }
        else 
        {
            return Product::with('productType:id,name', 'size:id,name' , 'material:id,mq_r_code')
                        ->select('id' , 'produce_code', 'material_id' , 'product_type_id' , 'size_id' , 'status', DB::raw('count(*) as total'))
                        ->where('status', 'available')
                        ->orderBy('material_id')
                        ->groupBy('produce_code');
        }
      
    }

    public function map($product_group): array
    {

        /*foreach($order->buyOrderProducts as $buy_product)
        {
            $product = Product::with('material:id,mq_r_code' , 'size:id,name')->where('produce_code' , $buy_product->produce_code)->first();
            if($product)
            {
                //$res = $res . ' - [ $product->material->mq_r_code ] - [] '
                $res = $res . ' - ' .   '[' . ($product->productType ? $product->productType->name : '')              . ']' . '[' .  $product->material->mq_r_code . '] [' . ($buy_product->company_qty + $buy_product->factory_qty) . '] [' . $product->size->name . ']' ; 
            }
            $total += $buy_product->company_qty + $buy_product->factory_qty;
        }*/
        return [
            //'fgfgfg'
            $product_group->productType->name,
            $product_group->material->mq_r_code,
            $product_group->size->name,
            $product_group->total,
            /*$order->delivery_date,
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
            $total,*/
        ];
    }

    public function headings(): array
    {
        return [
            'المنتج' ,
            'الكود',
            'المقاس' ,
            'الكمية المتاحة'
          
        ];
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
