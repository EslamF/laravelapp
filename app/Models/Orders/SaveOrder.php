<?php

namespace App\Models\Orders;

use App\Models\Products\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;

class SaveOrder extends Model
{
    protected $fillable = ['code', 'stored' , 'user_id'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class , 'created_by'); //created by
    }

    public function shippinguser()
    {
        return $this->belongsTo(User::class , 'user_id'); //created by
    }
}
