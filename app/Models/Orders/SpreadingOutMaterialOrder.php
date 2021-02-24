<?php

namespace App\Models\Orders;

use App\User;
use App\Models\Materials\Material;
use App\Models\Orders\CuttingOrder;
use App\Models\Organization\Factory;
use Illuminate\Database\Eloquent\Model;

class SpreadingOutMaterialOrder extends Model
{
    protected $fillable = ['user_id', 'material_id', 'weight', 'created_by' , 'factory_id'];

    protected $appends = ['type'];
    
    /**
     * 
     * relations
     * 
     */
    
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function spreadinguser()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'created_by');
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }

    public function cuttingOrders()
    {
        return $this->hasMany(CuttingOrder::class);
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
}
