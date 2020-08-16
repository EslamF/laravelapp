<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'phone', 'address', 'source', 'link', 'type'];
}