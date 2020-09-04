<?php

namespace App\Models\Orders;

use App\Models\Orders\BuyOrder;
use App\Models\Organization\ShippingCompany;
use Illuminate\Database\Eloquent\Model;

class ShippingOrder extends Model
{
    protected $fillable = ['shipping_code', 'shipping_date', 'shipping_company_id', 'status'];

    public function buyOrders()
    {
        return $this->belongsToMany(BuyOrder::class);
    }

    public function shippingCompany()
    {
        return $this->belongsTo(ShippingCompany::class);
    }
}
