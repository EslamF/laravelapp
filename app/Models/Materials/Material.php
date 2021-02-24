<?php

namespace App\Models\Materials;

use App\User;
use App\Models\Materials\MaterialType;
use App\Models\Orders\CuttingOrder;
use App\Models\Orders\SpreadingOutMaterialOrder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization\Supplier;
use Carbon\Carbon;

class Material extends Model
{
    protected $fillable = [
        'mq_r_code',
        'material_type_id',
        'buyer_id',
        'supplier_id',
        'qty',
        'weight',
        'bill_number',
        'description',
        'color',
        'created_by',
        'number_of_vestments'
    ];

    /**
     * 
     * relations
     * 
     */
    public function materialType()
    {
        return $this->belongsTo(MaterialType::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function cuttingOrders()
    {
        return $this->hasManyThrough(CuttingOrder::class, SpreadingOutMaterialOrder::class, 'material_id', 'spreading_out_material_order_id');
    }

    public function spreadingOutMaterialOrders()
    {
        return $this->hasMany(SpreadingOutMaterialOrder::class);
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
