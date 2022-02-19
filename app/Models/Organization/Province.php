<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = "provinces";

    protected $fillable = ['name'];

    public function buy_orders()
    {
        return $this->hasMany('App\Models\Organization\Province');
    }
}
