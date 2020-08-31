<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['id','name','label',''];

    public function  peremissions(){
        return $this->belongsToMany(peremission::class);
    }
    
    public function  allowTo($peremission){
     return $this->peremissions()->sync($peremission,false);
   }

}