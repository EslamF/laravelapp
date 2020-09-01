<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class BuyOrderProduct extends Model
{
    protected $fillable = ['buy_order_id', 'produce_code', 'factory_qty', 'company_qty', 'price'];

    public function buyOrder()
    {
        return $this->belongsTo(BuyOrder::class, 'buy_order_product');
    }
}
