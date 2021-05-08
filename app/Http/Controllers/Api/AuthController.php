<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email'    => 'required|exists:users,email',
            'password' => 'required'
        ];

        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) 
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }

        $user = User::where('email' , $request->email)
                     ->first();
        if($user)
        {
            if(Hash::check($request->password , $user->password))
            {
                $token = auth('api')->login($user);
                return $this->respondWithToken($token , $user);
            
            }
            else 
            {
               return responseJson(0 , 'كلمة السر خاطئة');
            }
        }
                 
        else 
        {
            return responseJson(0 , 'بيانات الدخول خاطئة');
        }
    
    }

    protected function respondWithToken($token , $user)
    {
        return responseJson(1 , 'success' , [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60 ,
            'user' => $user
        ] );
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}
