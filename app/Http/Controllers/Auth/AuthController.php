<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function userSignin()
    {
        return view('auth.signin-user');
    }
    
    public function adminSignin()
    {
        return view('auth.signin-admin');
    }
}
