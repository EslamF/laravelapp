<?php

namespace App\Models\Products;

use App\Models\Orders\CuttingOrderProduct;
use App\Models\Orders\ReceivingOrder;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }
}
