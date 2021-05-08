<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Organization\Factory;

class MainController extends Controller
{
    public function spreading_users()
    {
        $users =  User::whereHas('roles', function ($q) {
            $q->whereHas('permissions', function ($query) {
                $query->where('name', 'spreading-material');
            });
        })->get();

        return responseJson(1 , 'success' , $users);
    }

    public function factories() 
    {
        $factories =  Factory::get();
        return responseJson(1 , 'success' , $factories);
    }
}
