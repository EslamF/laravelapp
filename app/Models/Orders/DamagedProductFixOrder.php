<?php

namespace App\Models\Orders;

use App\Models\Products\Product;
use App\Models\Organization\Factory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DamagedProductFixOrder extends Model
{
    protected $fillable = ['product_id', 'factory_id'];

    /**
     * 
     * relations
     * 
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class);
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
