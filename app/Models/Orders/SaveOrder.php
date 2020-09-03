<?php

namespace App\Models\Orders;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class SaveOrder extends Model
{
    protected $fillable = ['code', 'stored'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
