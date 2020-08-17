<?php

namespace App\Models\Materials;
use App\User;
use App\Models\Materials\MaterialType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization\Supplier;

class Material extends Model
{
    protected $fillable = [
        'code', 'mq_r_code',
        'material_type_id',
        'user_id',
        'supplier_id',
        'qty',
        'weight',
        'bill_number',
        'description',
        'color'
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}