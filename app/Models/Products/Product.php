<?php

namespace App\Models\Products;

use App\Models\Orders\ReceivingOrder;
use App\User;
use App\Models\Orders\SortOrder;
use App\Models\Products\ProductType;
use Illuminate\Database\Eloquent\Model;

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
        'sort_date',
        'save_order_id',
        'user_id',
        'stored',
        'cutting_order_product_id'
    ];


    public function sortOrder()
    {
        return $this->belongsTo(SortOrder::class, 'sort_order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function receivingOrder()
    {
        return $this->belongsTo(ReceivingOrder::class);
    }
}
