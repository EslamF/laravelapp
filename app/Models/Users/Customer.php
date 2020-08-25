<?php

namespace App\Models\Users;

use App\Models\Orders\BuyOrder;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'phone', 'address', 'source', 'link', 'type'];

    /**
     * 
     * 
     * relations
     * 
     */

    public function buyOrders()
    {
        return $this->hasMany(BuyOrder::class);
    }
}
