<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class StoreProductOrder extends Model
{
    protected $fillable = ['code', 'save_order_id'];

    public function user()
    {
        return $this->belongsTo(User::class , 'created_by');
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
