<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('public_views.user_document');
    }

    public function editProfile(string $id)
    {
        if(Auth::guard('admin')->check()){
            $user = Admin::find($id);
        }else{
            $user = User::find($id);
        };

        if(!$user) return redirect()->route('home')->with('toast_error', 'User Not Found');

        return view('user_views.edit_profile', compact('user'));
    }

    public function updateProfile(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'nullable|string|unique:users,username,'.$id.',id',
            'profile_picture' => 'nullable|mimes:png,jpg,jpeg|max:1024',
            'old_password' => 'nullable',
            'new_password' => 'nullable|min:6',
            'confirm_password' => 'required_with:new_password|same:new_password',
        ]);

        if($validator->fails()){
            return back()
            ->with('toast_error', join(', ', $validator->messages()->all()))
            ->withInput();
        }

        $data = $validator->safe()->all();

        if(Auth::guard('admin')->check()){
            $user = Admin::find($id);
        }else{
            $user = User::find($id);
        };


        if(!$user) return redirect()->route('home')->with('toast_error', 'User Not Found');

        try {
        if($request->confirm_password){
            if (!(Hash::check($request->old_password, $user->password))) {
                return redirect()->back()->with('toast_error', 'The old password invalid');   
            }
            $data['password'] = $data['new_password'];
        }

        if($request->profile_picture){
            $file = $request->profile_picture;
            $fileName = Str::random(10).$file->getClientOriginalName();
            // Store new profile
            $file->storeAs('public/profile/', $fileName);
            $data['profile_picture'] = $fileName;

            // Delete old profile
            Storage::delete('public/profile/'.$user->profile_picture);

        }

            $user->update($data);

            return redirect()->route('home')->with('toast_success', 'Your profile updated');
        } catch (\Throwable $th) {

            return back()->with('toast_error', $th->getMessage());
        }

    }
}
