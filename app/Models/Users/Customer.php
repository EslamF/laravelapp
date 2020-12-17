<?php

namespace App\Models\Users;

use App\Models\Orders\BuyOrder;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'phone', 'address', 'source', 'link', 'type', 'observation' , 'notes' , 'number_of_orders' , 'total_price'];

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
    

    public function getNumberOfOrdersAttribute()
    {
        return $this->buyOrders->count();
    }
    public function getTotalPriceAttribute()
    {
        $total = 0;
        foreach($this->buyOrders as $order)
        {
            $total+= $order->orderTotal();
        }
        return $total;
    }
}
