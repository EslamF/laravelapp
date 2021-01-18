<?php

use Illuminate\Database\Seeder;
use App\Models\Products\Product;

class UpdateProductsCodes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::select('id', 'prod_code' , 'produce_code')->get();
        foreach($products as $product)
        {
            $product->prod_code = $product->produce_code;
            $product->save();
        };
    }
}
