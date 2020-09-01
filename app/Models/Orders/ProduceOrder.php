<?php

namespace App\Models\Orders;

use App\Models\Materials\Material;
use App\Models\Orders\CuttingOrder;
use App\Models\Orders\SpreadingOutMaterialOrder;
use App\Models\Organization\Factory;
use Illuminate\Database\Eloquent\Model;

class ProduceOrder extends Model
{
    protected $fillable = ['cutting_order_id', 'factory_id', 'receiving_date'];

    /**
     * 
     * relations
     * 
     */
    public function cuttingOrder()
    {
        return $this->belongsTo(CuttingOrder::class);
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }
}
