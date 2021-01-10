<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products\Product;
use App\Models\Orders\BuyOrder;

class ShippingCompany extends Model
{
    protected $fillable = ['name'];


    public function buyOrders()
    {
        return $this->hasMany(BuyOrder::class);
    }
}
