<?php

namespace App\Models\Organization;

use App\Models\Organization\Factory;
use Illuminate\Database\Eloquent\Model;

class FactoryType extends Model
{
    protected $fillable = ['name'];

    /**
     * 
     * relations
     * 
     */
    public function factories()
    {
        return $this->hasMany(Factory::class);
    }
}