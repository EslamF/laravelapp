<?php

namespace App\Models\Materials;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vestment extends Model
{
    protected $table = 'vestments';
    protected $fillable = ['material_id' , 'name' , 'weight', 'barcode' , 'status' , 'spreading_out_material_order_id'];

    public function material()
    {
        return $this->belongsTo('App\Models\Materials\Material');
    }

    public function spreadingOutMaterialOrder()
    {
        return $this->belongsTo('App\Models\Orders\SpreadingOutMaterialOrder');
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
