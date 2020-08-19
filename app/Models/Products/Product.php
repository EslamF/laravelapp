<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\SortOrder;

class Product extends Model
{
    protected $fillable = [
        'prod_code',
        'receiving_order_id',
        'sorted',
        'damage_type',
        'description',
        'status',
        'sort_order_id',
        'sort_date'
    ];


    public function sortOrder()
    {
        return $this->belongsTo(SortOrder::class, 'sort_order_id');
    }
}