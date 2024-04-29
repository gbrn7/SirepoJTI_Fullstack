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
        if(Auth::guard('web')->check() || Auth::guard('admin')->check())return redirect()->route('home');

        return view('auth.signin-user');
    }
    
    public function adminSignin()
    {
        if(Auth::guard('web')->check() || Auth::guard('admin')->check())return redirect()->route('home');

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

        return back()->with('toast_error', 'Username or password invalid!');
    }

    public function signOut(Request $request)
    {
        if(Auth::guard('web')->check()){
            Auth::guard('web')->logout();
        }elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('signIn.user')->with('toast_success', 'Sign out success');
    }
}
