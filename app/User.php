<?php

namespace App;

use App\Models\Materials\Material;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Role;
use Laratrust\Traits\LaratrustUserTrait;


class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function  roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function  receivering()
    {
        return $this->hasMany(Material::class);
    }
    public function  buying()
    {
        return $this->hasMany(Material::class);
    }

    public function  assignRole($role)
    {

        return $this->roles()->sync($role, true);
    }

    public function  peremissions()
    {
        return $this->roles->map->peremissions->flatten()->pluck('name')->unique();
    }

    public function sortOrders()
    {
        return $this->belongsToMany(SortOrder::class);
    }
}
