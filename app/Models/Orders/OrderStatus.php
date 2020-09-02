<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = ['buy_order_id', 'status', 'status_message'];
}
