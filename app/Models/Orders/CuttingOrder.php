<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Orders\SpreadingOutMaterialOrder;
use App\Models\Products\ProductType;
use App\Models\Options\Size;

class CuttingOrder extends Model
{
    protected $fillable = [
        'spreading_out_material_order_id',
        'user_id',
        'layers',
        'product_type_id',
        'size_id',
        'qty',
        'extra_returns_weight'
    ];

    /**
     * 
     * relations
     * 
     */
    public function spreadingOutMaterialOrder()
    {
        return $this->belongsTo(SpreadingOutMaterialOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}