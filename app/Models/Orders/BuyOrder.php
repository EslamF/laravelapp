<?php

namespace App\Models\Orders;

use App\Models\Products\Product;
use App\Models\Users\Customer;
use App\Models\Orders\ShippingOrder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\OrderStatus;

class BuyOrder extends Model
{
    protected $fillable = [
        'customer_id',
        'description',
        'bar_code',
        'status',
        'confirmation',
        'preparation',
        'delivery_date',
        'source',
        'pending_date'
    ];

    protected $appends = ['confirmation_color' , 'status_color' , 'translate_confirmation' , 'translate_preparation' , 'translate_status']; 

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

    public function orderStatus()
    {
        return $this->hasMany(OrderStatus::class);
    }

    public function user()
    {
        return $this->belongsTo('App\User' , 'created_by');
    }

    public function getConfirmationColorAttribute()
    {
        if($this->confirmation == 'pending')
        {
            return 'bg-primary' ;
        }

        else if($this->confirmation == 'confirmed')
        {
            return 'bg-success' ;
        }

        else if($this->confirmation == 'canceled')
        {
            return 'bg-danger' ;
        }

        else if($this->confirmation == 'delayed')
        {
            return 'bg-warning' ;
        }

        else 
        {
            return '';
        }
    }

    public function getStatusColorAttribute()
    {
        if($this->status == 'pending')
        {
            return 'bg-primary' ;
        }

        else if($this->status == 'done')
        {
            return 'bg-success' ;
        }

        else if($this->status == 'rejected')
        {
            return 'bg-danger' ;
        }

        else if($this->status == 'returned')
        {
            return 'bg-warning' ;
        }

        else 
        {
            return '';
        }
    }

    public function getTranslateConfirmationAttribute()
    {
        return __('words.' . $this->confirmation);
    }

    public function getTranslatePreparationAttribute()
    {
        return __('words.' . $this->preparation);
    }

    public function getTranslateStatusAttribute()
    {
        return __('words.' . $this->status . '_order');
    }
}
