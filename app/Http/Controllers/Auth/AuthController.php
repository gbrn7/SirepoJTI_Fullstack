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
            'isAdmin' => 'nullable|boolean',
            'isLecturer' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', join(', ', $validator->messages()->all()))
                ->withInput()
                ->withErrors($validator->messages());
        }

        $credentials = $validator->safe()->only('username', 'password');

        if ($validator->safe()->only('isAdmin')) {
            // Auth::setDefaultDriver('admin');
            $auth = Auth::guard('admin');
        } else if ($validator->safe()->only('isLecturer')) {
            $auth = Auth::guard('lecturer');
        } else {
            $auth = Auth::guard('student');
        }

        if (!$auth->attempt($credentials)) {
            return back()->with('toast_error', 'Username or password invalid!');
        }

        $request->session()->regenerate();

        return redirect()->route('welcome');
    }

    public function signOut(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('lecturer')->check()) {
            Auth::guard('lecturer')->logout();
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('signIn.student')->with('toast_success', 'Log out sukses');
    }
}
