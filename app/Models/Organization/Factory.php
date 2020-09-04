<?php

namespace App\Models\Organization;

use App\Models\Orders\CuttingOrder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization\FactoryType;

class Factory extends Model
{
    protected $fillable = ['name', 'factory_type_id', 'phone', 'address'];

    /**
     * 
     * relations
     * 
     */
    public function factoryType()
    {
        return $this->belongsTo(FactoryType::class);
    }

    public function cuttingOrder()
    {
        return $this->hasMany(CuttingOrder::class);
    }
}
