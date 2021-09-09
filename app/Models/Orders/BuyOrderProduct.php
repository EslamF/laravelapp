<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products\Product;

class BuyOrderProduct extends Model
{
    protected $fillable = ['buy_order_id', 'produce_code', 'factory_qty', 'company_qty', 'price' , 'product_material_code'];

    protected $appends = ['mq_r_code' , 'product_type'];

    public function buyOrder()
    {
        return $this->belongsTo(BuyOrder::class, 'buy_order_product');
    }

    public function getMqRCodeAttribute()
    {
        $mq_r_code = '';

        $product = Product::where('product_material_code' , $this->product_material_code)->first();

        if($product)
        {
            $mq_r_code = $product->material ? $product->material->mq_r_code : '' ;
        }

        return $mq_r_code;
    }

    public function getProductTypeAttribute()
    {
        $product_type = '';

        $product = Product::where('product_material_code' , $this->product_material_code)->first();

        if($product)
        {
            $product_type = $product->productType ? $product->productType->name : '' ;
        }

        return $product_type;
    }
}
