<?php

namespace App\Models\Orders;

use App\User;
use App\Models\Materials\Material;
use App\Models\Orders\CuttingOrder;
use Illuminate\Database\Eloquent\Model;

class SpreadingOutMaterialOrder extends Model
{
    protected $fillable = ['user_id', 'material_id', 'weight'];


    /**
     * 
     * relations
     * 
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cuttingOrders()
    {
        return $this->hasMany(CuttingOrder::class);
    }
}
