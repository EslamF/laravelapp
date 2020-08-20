<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class StoreProductOrder extends Model
{
    protected $fillable = ['code', 'save_order_id'];
}
