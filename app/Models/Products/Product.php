<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['prod_code', 'receiving_order_id', 'damaged', 'sorted', 'description'];
}