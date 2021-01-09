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

class Products2Import implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        /*$m_size = Size::where('name' , 'M')->first();
        $l_size = Size::where('name' , 'L')->first();
        $xl_size = Size::where('name' , 'XL')->first();
        $xxl_size = Size::where('name' , 'XXL')->first();
        $xxxl_size = Size::where('name' , 'XXXL')->first();*/

        //$save_order = null;
        $save_order = SaveOrder::create([
            'code' => $this->generateOrderCode(),
            'stored' => 1
        ]);
       
        ini_set('max_execution_time', 0);
        foreach ($collection as $key => $value) 
        {
            //dd($value[1]);
            if ($key == 0 || $key == 1 || $key == 2) 
            {
                continue;
            }
            else 
            {
                // value[0] => id
                // value[1] => product number
                // value[2] => codes array 
                // value[3] => quantity
                // value[4] => bar code
                // value[5] => product name
               
                $codes_array = explode(" " , $value[2]);
                $codes_array = array_filter($codes_array);
                $codes_array = array_values($codes_array);

                if(count($codes_array) < 3 || strtoupper($codes_array[0]) != 'CODE' || !$value[4] || !$value[5] || is_numeric($codes_array[2]) )
                {
                    continue;
                }

                $quantity = (int)$value[3];
                $size_name = strtoupper($codes_array[2]);
                $size = Size::where('name' , $size_name)->first();
                if(!$size)
                {
                    $size = Size::create(['name' => $size_name]);
                }
              
                $product_type = ProductType::where('name' , $value[5])->first();
                if(!$product_type)
                {
                    $product_type = ProductType::create([ 'name' => $value[5] ]);
                }

                $material = Material::where('mq_r_code' , $codes_array[1])->first();
                if(!$material)
                {
                    $material = Material::create([
                        'mq_r_code' => $codes_array[1],
                        'material_type_id' => MaterialType::first()->id,
                        'buyer_id' => User::first()->id,
                        'supplier_id' => Supplier::first()->id,
                        'weight' => 1000,
                        'bill_number' => $key + 150,
                        'color' => "أبيض",
                    ]);
                }
              
                $this->store_products($product_type->id , $size->id    , $material->id ,  $quantity ,$save_order->id , $value[4] ); //Medium
             
                 
            }
        }
    }

    public function store_products($product_type_id , $size_id , $material_id , $qty , $save_order_id , $bar_code)
    {
        

        for ($i = 0; $i < $qty; $i++) {

            $product = Product::where('product_type_id', $product_type_id)
                            ->where('size_id', $size_id)
                            ->where('material_id', $material_id)
                            ->first();

            $product_material_code = Product::where('product_type_id' , $product_type_id)
                                        ->where('material_id' , $material_id)
                                        ->first();
            Product::create([
                'prod_code' => $this->generateCode(),
                'produce_code' => $bar_code,
                'sorted'     => 1,
                'size_id'   => $size_id,
                'material_id'   => $material_id,
                'product_type_id' => $product_type_id,
                'received'  => 1,
                'status'    => 'available',
                'save_order_id' => $save_order_id,
                'product_material_code' => $product_material_code->product_material_code ?? $this->generateProductMaterialCode()

            ]);
        }
    }

    public function generateOrderCode()
    {
        $code = rand(0, 6000000000000);
        $check = Product::where('produce_code', $code)->exists();
        if ($check) {
            $this->generateOrderCode();
        } else {
            return $code;
        }
    }

    public function generateCode()
    {
        $code = rand(0, 6000000000000);
        $check = Product::where('prod_code', $code)->exists();
        if ($check) {
            $this->generateCode();
        } else {
            return $code;
        }
    }

    public function generateProductMaterialCode()
    {
        $code = rand(0, 6000000000000);
        $check = Product::where('product_material_code', $code)->exists();
        if ($check) {
            $this->generateProductMaterialCode();
        } else {
            return $code;
        }
    }
}
