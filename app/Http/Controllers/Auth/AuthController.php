<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function studentSignin()
    {
        if (Auth::guard('student')->check() || Auth::guard('admin')->check()) return redirect()->route('welcome');

        return view('auth.signin-student');
    }

    public function adminSignin()
    {
        if (Auth::guard('student')->check() || Auth::guard('admin')->check()) return redirect()->route('welcome');

        return view('auth.signin-admin');
    }

    public function lecturerSignin()
    {
        if (Auth::guard('student')->check() || Auth::guard('admin')->check()) return redirect()->route('welcome');

        return view('auth.signin-lecturer');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required',
            'isAdmin' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', join(', ', $validator->messages()->all()))
                ->withInput()
                ->withErrors($validator->messages());
        }

        $credentials = $validator->safe()->only('username', 'password');


        if ($validator->safe()->only('isAdmin')) {
            // Auth::setDefaultDriver('admin');

            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->route('welcome');
            }
        } else {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->route('welcome');
            }
        }

        return back()->with('toast_error', 'Username or password invalid!');
    }

    public function signOut(Request $request)
    {
        if (Auth::guard('student')->check()) {
            Auth::guard('student')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('signIn.student')->with('toast_success', 'Log out sukses');
    }
}
