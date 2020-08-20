<?php

namespace App\Models\Products;

use App\Models\Orders\ReceivingOrder;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasManyThrough(Product::class, ReceivingOrder::class, 'product_type_id', 'receiving_order_id');
    }
}
