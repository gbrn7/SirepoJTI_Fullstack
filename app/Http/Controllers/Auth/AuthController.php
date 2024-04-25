<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required',
            'isAdmin' => 'nullable|boolean'
        ] );

        if($validator->fails()){
            return back()->with('toast_error', join(', ', $validator->messages()->all()))
            ->withInput()
            ->withErrors($validator->messages());
        }

        $credentials = $validator->safe()->only('username', 'password');


        if($validator->safe()->only('isAdmin')){
            // Auth::setDefaultDriver('admin');

            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                
                return redirect()->route('home');
            }
        }else{
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
     
                return redirect()->route('home');
            }
        }

        return back()->with('toast_error', 'Username or Password invalid!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('signIn.user')->with('toast_success', 'Berhasil Keluar');
    }
}
