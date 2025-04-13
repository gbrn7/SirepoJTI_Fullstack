<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use App\Support\Interfaces\Services\AdminServiceInterface;
use App\Support\Interfaces\Services\LecturerServiceInterface;
use App\Support\Interfaces\Services\StudentServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class userController extends Controller
{

    public function __construct(
        protected StudentServiceInterface $studentService,
        protected LecturerServiceInterface $lecturerService,
        protected AdminServiceInterface $adminService,
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('public_views.user_document');
    }

    public function editProfile(string $ID)
    {
        if (Auth::guard('admin')->check()) {
            $user = $this->adminService->getAdminByID($ID);
        } else {
            $user = $this->studentService->getStudentByID($ID);
        };

        if (!$user) return redirect()->route('home')->with('toast_error', 'User Not Found');

        return view('user_views.edit_profile', compact('user'));
    }

    public function updateProfile(Request $request, string $ID)
    {
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'nullable|mimes:png,jpg,jpeg|max:1024',
            'old_password' => 'nullable',
            'new_password' => 'nullable|min:6',
            'confirm_password' => 'required_with:new_password|same:new_password',
        ], [
            'confirm_password.same' => 'Pengulangan Password Tidak Sama',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', join(', ', $validator->messages()->all()))
                ->withInput();
        }

        $data = $validator->safe()->all();

        try {
            if (Auth::guard('admin')->check()) {
                $this->adminService->updateAdmin($ID, $data);
            } else {
                $this->studentService->updateStudent($ID, $data);
            };

            return back()->with('toast_success', 'Profil Diperbarui');
        } catch (\Throwable $th) {

            return back()->with('toast_error', $th->getMessage());
        }
    }
}
