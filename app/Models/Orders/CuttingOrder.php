<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Orders\SpreadingOutMaterialOrder;
use App\Models\Products\ProductType;
use App\Models\Options\Size;
use App\Models\Organization\Factory;

class CuttingOrder extends Model
{
    protected $fillable = [
        'user_id',
        'layers',
        'factory_id',
        'extra_returns_weight'
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
}
