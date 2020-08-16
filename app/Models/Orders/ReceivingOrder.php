<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class ReceivingOrder extends Model
{
    protected $fillable = ['produce_order_id', 'product_type_id', 'qty', 'status'];
}