<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use App\User;

class StoreProductOrder extends Model
{
    protected $fillable = ['code', 'save_order_id'];

    public function user()
    {
        return $this->belongsTo(User::class , 'created_by');
    }
}
