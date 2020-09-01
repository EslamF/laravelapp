<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['id','name','label','description'];

    public function  peremissions(){
        return $this->belongsToMany(peremission::class);
    }
    
    public function  allowTo($peremission){
        // dd($peremission);
     return $this->peremissions()->sync($peremission);
   }

   public function  users(){
    return $this->belongsToMany(User::class);
}
}