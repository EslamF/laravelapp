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

class ProductsImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $m_size = Size::where('name' , 'M')->first();
        $l_size = Size::where('name' , 'L')->first();
        $xl_size = Size::where('name' , 'XL')->first();
        $xxl_size = Size::where('name' , 'XXL')->first();
        $xxxl_size = Size::where('name' , 'XXXL')->first();

        $save_order = SaveOrder::create([
            'code' => $this->generateOrderCode(),
            'stored' => 1
        ]);
       
        ini_set('max_execution_time', 0);
        foreach ($collection as $key => $value) 
        {
            if ($key == 0 || $key == 1) 
            {
                continue;
            } else 
            {
                $product_type = ProductType::where('name' , $value[0])->first();
                if(!$product_type)
                {
                    $product_type = ProductType::create([ 'name' => $value[0] ]);
                }

                $material = Material::where('mq_r_code' , $value[1])->first();
                if(!$material)
                {
                    $material = Material::create([
                        'mq_r_code' => $value[1],
                        'material_type_id' => MaterialType::first()->id,
                        'buyer_id' => User::first()->id,
                        'supplier_id' => Supplier::first()->id,
                        'weight' => 1000,
                        'bill_number' => $key + 150,
                        'color' => "أبيض",
                    ]);
                }
                //check if there is quantity
                if($value[2])
                {
                    $this->store_products($product_type->id , $m_size->id    , $material->id ,  $value[2] ,$save_order->id  ); //Medium
                }
                
                if($value[3])
                {
                    $this->store_products($product_type->id , $l_size->id    , $material->id ,  $value[3] ,$save_order->id  ); //Large
                }

                if($value[4])
                {
                    $this->store_products($product_type->id , $xl_size->id   , $material->id ,  $value[4] ,$save_order->id  ); //X Large
                }

                if($value[5])
                {
                    $this->store_products($product_type->id , $xxl_size->id  , $material->id ,  $value[5] ,$save_order->id  ); //2X Large
                }
                
                if($value[6])
                {
                    $this->store_products($product_type->id , $xxxl_size->id , $material->id ,  $value[6] ,$save_order->id  ); //3X Large
                }
            }
        }
    }

    public function store_products($product_type_id , $size_id , $material_id , $qty , $save_order_id)
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
                'produce_code' => $product->produce_code ?? $this->generateOrderCode(),
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
