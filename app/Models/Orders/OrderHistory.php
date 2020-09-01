<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $fillable = ['pending_date', 'status', 'buy_order_id'];
}
