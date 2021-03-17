<?php

namespace App\Models\Orders;

use App\Models\Materials\Material;
use App\Models\Orders\CuttingOrder;
use App\Models\Orders\SpreadingOutMaterialOrder;
use App\Models\Organization\Factory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products\Product;
use App\User;
use Carbon\Carbon;

class ProduceOrder extends Model
{
    protected $fillable = ['cutting_order_id', 'factory_id', 'receiving_date' , 'out_date' , 'status' , 'can_edit'];

    /**
     * 
     * relations
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class , 'created_by');
    }
    public function cuttingOrder()
    {
        return $this->belongsTo(CuttingOrder::class);
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }

    public function products()
    {
        return $this->hasMany('App\Models\Products\Product'); 
    }

    public function getCanEditAttribute()
    {
        $count = Product::where('produce_order_id' , $this->id)
                        ->where('received' , 1)
                        ->count();
        if($count > 0)
        {
            return false;
        }
        else 
        {
            return true;
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
