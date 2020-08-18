<?php

namespace App\Models\Orders;

use App\User;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class SortOrder extends Model
{
    protected $fillable =  ['code', 'user_id'];

    /**
     * 
     * relation
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sort_order');
    }

}
