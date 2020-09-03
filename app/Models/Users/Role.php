<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\Peremission;

class Role extends Model
{
    protected $fillable = ['id', 'label', 'description'];

    public function  peremissions()
    {
        return $this->belongsToMany(Peremission::class);
    }

    public function  allowTo($peremission)
    {
        // dd($peremission);
        return $this->peremissions()->sync($peremission);
    }

    public function  users()
    {
        return $this->belongsToMany(User::class)->withTimestambs();
    }
}
