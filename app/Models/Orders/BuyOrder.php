<?php

namespace App\Models\Orders;

use App\Models\Products\Product;
use App\Models\Users\Customer;
use App\Models\Orders\ShippingOrder;
use Illuminate\Database\Eloquent\Model;

class BuyOrder extends Model
{
    protected $fillable = ['customer_id', 'description', 'bar_code', 'status', 'confirmation', 'preparation', 'delivery_date'];

    /**
     * 
     * relations 
     * 
     */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function buyOrderProducts()
    {
        return $this->hasMany(BuyOrderProduct::class);
    }


    public function orderTotal()
    {
        return $this->buyOrderProducts()->get()->map(function ($item) {
            $qty = $item->company_qty +  $item->factory_qty;
            return $item->price * $qty;
        })->sum();
    }

    public function productStatus()
    {
        return ($this->buyOrderProducts->sum('factory_qty') == 0 && $this->buyOrderProducts->sum('company_qty') > $this->buyOrderProducts->sum('factory_qty')) ? true : false;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'buy_order_product');
    }

    public function shippingOrders()
    {
        return $this->belongsToMany(ShippingOrder::class);
    }
}
