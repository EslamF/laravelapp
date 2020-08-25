<?php

namespace App\Models\Orders;

use App\Models\Users\Customer;
use Illuminate\Database\Eloquent\Model;

class BuyOrder extends Model
{
    protected $fillable = ['customer_id', 'price', 'description', 'bar_code'];

    /**
     * 
     * relations 
     * 
     */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
