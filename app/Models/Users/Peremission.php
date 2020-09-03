<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Peremission extends Model
{
    protected $fillable = ['id','name','label'];
    
    public function  roles(){
        return $this->belongsToMany(Role::class)->withTimestambs();
    }    
}