<?php

namespace App\Imports;

use App\Models\Orders\SaveOrder;
use App\Models\Orders\OrderStatus;
use App\Models\Organization\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use App\Models\Options\Size;
use App\Models\Products\Product;
use App\Models\Products\ProductType;
use App\Models\Materials\MaterialType;
use App\Models\Materials\Material;
use App\User;
use App\Models\Users\Customer;
use App\Models\Orders\BuyOrder;
use App\Models\Orders\BuyOrderProduct;

class BuyOrdersImport implements ToCollection
{
    
    public $date;
    public $i = 0;

    public function  __construct($date)
    {
        $this->date= $date;
    }

    public function collection(Collection $collection)
    {
        $m_size = Size::where('name' , 'M')->first();
        $l_size = Size::where('name' , 'L')->first();
        $xl_size = Size::where('name' , 'XL')->first();
        $xxl_size = Size::where('name' , '2XL')->first();
        $xxxl_size = Size::where('name' , '3XL')->first();
        $xxxxl_size = Size::where('name' , '4XL')->first();

      
        ini_set('max_execution_time', 0);

        foreach ($collection as $key => $value) 
        {
            
            if ($key == 0 || $key == 1) 
            {
                continue;
            } 
            else 
            {
                /*$products_array = explode("/" , "920/966/960");
                $products_array = array_filter($products_array);
                $products_array = array_values($products_array);
                dd($products_array);*/
                
                $customer = Customer::updateOrCreate(['phone' => $value[5]], [
                    'name' => $value[2] ,
                    'address' => $value[3] ,
                    'source' => 'facebook' ,
                    'link'   => 'https://www.google.com/'
                ]);

                $order = BuyOrder::with('buyOrderProducts')->where('bar_code' , $value[1])->first();
                if($order)
                {
                    $count = count($order->buyOrderProducts);
                }
                if(!$order)
                {
                    $order = BuyOrder::create([
                        'customer_id' => $customer->id,
                        'description' => $value[7],
                        'bar_code' => $value[1],
                        'delivery_date' => $this->date,
                        'source'        => $customer->source ,
                        'price'     => $value[6]
                    ]);

                    $count = 0;
                }

                if($value[1] == "X624")
                {
                    error_log($order);
                }

                $counting = $count > 0 ? true : false;
                
                
                //check if number of pieces > 0
                
                if($value[13] > 0 && !$counting   )
                {
                    error_log('order : ' . $order->bar_code . ' count : ' . count($order->buyOrderProducts) . ' = ' . ($counting ? 'yes' : 'no') );
                    //error_log($value);
                    //$this->i++;
                    //error_log('i : ' . $this->i);
                    if(true ) // medium
                    {
                        $products_array = str_replace("Code","/", $value[8]); 
                        $products_array = str_replace("code","/", $products_array);  
                        $products_array = str_replace(" ","", $products_array); 
                        $products_array = explode("/" , $products_array);
                        $products_array = array_filter($products_array);
                        $products_array = array_values($products_array);
                        error_log('array medium : ' . reset($products_array));
                        $this->add_products($m_size->id , $products_array , $order->id );
                    }
                    if(true) // large
                    {
                        $products_array = str_replace("Code","/", $value[9]); 
                        $products_array = str_replace("code","/", $products_array);  
                        $products_array = str_replace(" ","", $products_array);
                        $products_array = explode("/" , $products_array);
                        $products_array = array_filter($products_array);
                        $products_array = array_values($products_array);
                        error_log('array large : ' . reset($products_array));
                        $this->add_products($l_size->id , $products_array , $order->id );
                    }
                    if(true) // x large
                    {
                        $products_array = str_replace("Code","/", $value[10]); 
                        $products_array = str_replace("code","/", $products_array);  
                        $products_array = str_replace(" ","", $products_array);
                        $products_array = explode("/" , $products_array);
                        $products_array = array_filter($products_array);
                        $products_array = array_values($products_array);
                        error_log('array x large : ' . reset($products_array));
                        $this->add_products($xl_size->id , $products_array , $order->id );
                    }
                    if(true) // 2x large
                    {
                        $products_array = str_replace("Code","/", $value[11]); 
                        $products_array = str_replace("code","/", $products_array);  
                        $products_array = str_replace(" ","", $products_array);
                        $products_array = explode("/" , $products_array);
                        $products_array = array_filter($products_array);
                        $products_array = array_values($products_array);
                        error_log('array xx large : ' . reset($products_array));
                        $this->add_products($xxl_size->id , $products_array , $order->id );
                    }
                    if(true) // 3xl
                    {
                        $products_array = str_replace("Code","/", $value[12]); 
                        $products_array = str_replace("code","/", $products_array);  
                        $products_array = str_replace(" ","", $products_array);
                        $products_array = explode("/" , $products_array);
                        $products_array = array_filter($products_array);
                        $products_array = array_values($products_array);
                        error_log('array xxx large : ' . reset($products_array));
                        $this->add_products($xxxl_size->id , $products_array , $order->id );
                    }
                    
    
                }
            }
        }
    }

    public function add_products($size_id , $material_codes , $buy_order_id)
    {
        foreach($material_codes as $code)
        {
            $material = Material::where('mq_r_code' , $code )->first();
            if($material)
            {
                error_log('material code : ' . $material->mq_r_code);
                $product = Product::where('size_id' , $size_id)->where('material_id' , $material->id)->first();
                if($product)
                {
                    error_log('product material id : ' . $product->material_id);
                    $record = BuyOrderProduct::where('buy_order_id' , $buy_order_id)
                                    ->where('product_material_code' , $product->product_material_code )
                                    ->where('produce_code' , $product->produce_code)
                                    ->first();

                    if($record)
                    {
                        $record->company_qty = $record->company_qty + 1;
                        $record->save();
                    }
                    else 
                    {
                        BuyOrderProduct::create([
                            'buy_order_id'             => $buy_order_id,
                            'product_material_code'    => $product->product_material_code ,
                            'produce_code'             => $product->produce_code,
                            'factory_qty'              => 0,
                            'company_qty'              => 1,
                            'price'                    => 0
                        ]);
                    }
                    
                }
                
            }
            
        }
    }
}
