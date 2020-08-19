<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products\Product;

class ShippingCompany extends Model
{
    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
