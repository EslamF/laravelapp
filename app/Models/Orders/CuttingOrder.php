<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Orders\SpreadingOutMaterialOrder;
use App\Models\Orders\CuttingOrderProduct;
use App\Models\Orders\ProduceOrder;
use App\Models\Organization\Factory;

class CuttingOrder extends Model
{
    protected $fillable = [
        'user_id',
        'layers',
        'factory_id',
        'extra_returns_weight',
        'spreading_out_material_order_id'
    ];

    /**
     * 
     * relations
     * 
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }

    public function produceOrders()
    {
        return $this->hasMany(ProduceOrder::class);
    }

    public function CuttingOrderProducts()
    {
        return $this->hasMany(CuttingOrderProduct::class);
    }

    public function spreadingOutMaterialOrder()
    {
        return $this->belongsTo(SpreadingOutMaterialOrder::class);
    }
}
