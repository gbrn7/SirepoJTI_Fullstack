<?php

namespace App\Http\Controllers;

use App\Models\Majority;
use App\Models\ProgramStudy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::OrderBy('id', 'desc')
                ->when($request->author, function($query) use ($request){
                    return $query->where('name', $request->author);
                })
                ->withCount('document')
                ->paginate(10);
                
        return view('admin_views.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $majority = Majority::first();

        $prodys = ProgramStudy::all();

        return view('admin_views.users.user_upsert_form', compact('majority', 'prodys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'program_study' => 'required',
            'profile_picture' => 'nullable|mimes:png,jpg,jpeg|max:1024',
        ]);

        if($validator->fails()) return redirect()
        ->back()
        ->withInput()
        ->with('toast_error', join(', ', $validator->messages()->all()));

        try {
            $data = $validator->safe()->all();

            if($request->profile_picture){
                // Store profile picture
                $file = $request->profile_picture;
                $fileName = Str::random(10).$file->getClientOriginalName();
                $file->storeAs('public/Profile/', $fileName);

                $data['profile_picture'] = $fileName;
            }

            $data['id_program_study'] = $data['program_study'];

            $user = User::create($data);

            $user->assignRole('user');
            
            return redirect()->route('user-management.index')->with('toast_success', 'User Added');
        } catch (\Throwable $th) {
            return redirect()
            ->route('user-management.create')
            ->withInput()
            ->with('toast_error', $th->getMessage());
    
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $majority = Majority::first();

        $prodys = ProgramStudy::all();

        $user = User::find($id);

        if(!$user) return redirect()->back()->with('toast_error', 'User not found');

        return view('admin_views.users.user_upsert_form', compact('majority', 'prodys', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable',
            'username' => 'nullable|unique:users,username,'.$id.'id',
            'email' => 'nullable|email|unique:users,email,'.$id.'id',
            'password' => 'nullable|min:6',
            'program_study' => 'nullable',
            'profile_picture' => 'nullable|mimes:png,jpg,jpeg|max:1024',
        ]);

        if($validator->fails()) return redirect()
        ->back()
        ->withInput()
        ->with('toast_error', join(', ', $validator->messages()->all()));

        try {
            // Find user
            $oldData = User::find($id);

            if(!$oldData) return redirect()->route('user-management.index')->with('toast_error', 'User not found'); 

            $newData = [];
            if($validator->safe()->name){
                $newData['name'] = $validator->safe()->name;
            }
            if($validator->safe()->username){
                $newData['username'] = $validator->safe()->username;
            }
            if($validator->safe()->email){
                $newData['email'] = $validator->safe()->email;
            }
            if($validator->safe()->password){
                $newData['password'] = $validator->safe()->password;
            }
            if($validator->safe()->program_study){
                $newData['id_program_study'] = $validator->safe()->program_study;
            }
            if($request->profile_picture){
                // Store profile picture
                $file = $request->profile_picture;
                $fileName = Str::random(10).$file->getClientOriginalName();
                $file->storeAs('public/Profile/', $fileName);

                $newData['profile_picture'] = $fileName;

                // Delete Old data
                Storage::delete('public/profile/'.$oldData->profile_picture);
            }
            
            
            $oldData->update($newData);

            return redirect()->route('user-management.index')->with('toast_success', 'User Updated');

        } catch (\Throwable $th) {
            return redirect()
            ->route('user-management.create')
            ->withInput()
            ->with('toast_error', $th->getMessage());
    
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);

            if(!$user) return redirect()->route('user-management.index')->with('toast_error', 'User Not Found');

            $user->delete();

            Storage::delete('profile/'.$user->profile_picture);

            return redirect()->route('user-management.index')->with('toast_success', 'User deleted');
        } catch (\Throwable $th) {
            return back()
            ->with('toast_error', $th->getMessage());
        }
    }
}
