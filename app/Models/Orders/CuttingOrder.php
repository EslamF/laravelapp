<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Orders\SpreadingOutMaterialOrder;
use App\Models\Orders\CuttingOrderProduct;
use App\Models\Orders\ProduceOrder;
use App\Models\Organization\Factory;
use App\Models\Products\Product;
use Carbon\Carbon;

class CuttingOrder extends Model
{
    protected $fillable = [
        'user_id',
        'layers',
        'factory_id',
        'extra_returns_weight',
        'spreading_out_material_order_id',
        'layers_weight',
    ];

    protected $appends = ['type' , 'status' , 'can_edit'];


    public function user()
    {
        return $this->belongsTo(User::class , 'created_by'); // created by
    }

    public function cuttinguser()
    {
        return $this->belongsTo(User::class , 'user_id'); // cutting employee user_id
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }

    public function produceOrders()
    {
        return $this->hasMany(ProduceOrder::class);
    }

    public function spreadingOutMaterialOrder()
    {
        return $this->belongsTo(SpreadingOutMaterialOrder::class);
    }

    public function getTypeAttribute()
    {
        if($this->user_id != null)
        {
            return 'inner' ;
        }
        else if($this->factory_id != null)
        {
            return 'outer';
        }

        else 
        {
            return '';
        }
    }

    public function getStatusAttribute()
    {
        $count = Product::where('cutting_order_id' , $this->id)
                        ->whereNull('produce_order_id')
                        ->count();

        if($count > 0)
        {
            return 'current' ;
        }
        else 
        {
            return 'previous' ;
        }
    }

    public function getCanEditAttribute()  
    {
        if(count($this->produceOrders) > 0)
        {
            return false ;
        }

        else 
        {
            return true ;
        }
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
