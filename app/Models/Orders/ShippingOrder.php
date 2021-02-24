<?php

namespace App\Models\Orders;

use App\Models\Orders\BuyOrder;
use App\Models\Organization\ShippingCompany;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class ShippingOrder extends Model
{
    protected $fillable = ['shipping_code', 'shipping_date', 'shipping_company_id', 'status'];

    public function buyOrders()
    {
        return $this->belongsToMany(BuyOrder::class);
    }

    public function shippingCompany()
    {
        return $this->belongsTo(ShippingCompany::class);
    }

    public function getCreatedAtAttribute($value)
    {
        if($value)
        {
            return Carbon::parse($value)
                        ->addHours(2)
                        ->format('Y-m-d h:i a');
        }
        else
        {
            return '';
        }
    }
}
