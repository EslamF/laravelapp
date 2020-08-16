<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class ProduceOrder extends Model
{
    protected $fillable = ['cutting_order_id', 'material_id' , 'qty', 'receiving_date', 'factory_id'];
}