<?php

namespace App\Models\Organization;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization\FactoryType;

class Factory extends Model
{
    protected $fillable = ['name', 'factory_type_id'];

    /**
     * 
     * relations
     * 
     */
    public function factoryType()
    {
        return $this->belogsTo(FactoryType::class);
    }
}