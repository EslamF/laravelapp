<?php

namespace App\Models\Materials;

use Illuminate\Database\Eloquent\Model;

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
}
