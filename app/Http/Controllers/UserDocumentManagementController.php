<?php

namespace App\Http\Controllers;

use App\Models\Thesis;
use App\Models\ThesisCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserDocumentManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $user = User::with('document')->find($id);

        if(!$user) return redirect()->back()->with('toast_error', 'User not found');

        return view('admin_views.users.documents.index',['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $userId)
    {
        $categories = ThesisCategory::all();

        $user = User::find($userId);

        if(!$user) return redirect()->back()->with('toast_error', 'User not found');

        return view('admin_views.users.documents.user_document_upsert_form', compact('categories', 'user'));    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $userId)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'abstract' => 'required',
            'category' => 'required',
            'file' => 'required|mimes:pdf|max:15360'
        ]);

        if($validator->fails()){
            return back()
            ->withInput()
            ->with('toast_error', join(', ', $validator->messages()->all()));
        }

        try {
            $data = $validator->safe()->all();

            // store file
            $file = $request->file;
                $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->storeAs('document/', $fileName);

            $data['file_name'] = $fileName;
            $data['id_category'] = $data['category'];
            $data['id_user'] = $userId;

            Thesis::create($data);

            Session::flash('toast_success', 'Document Added');
            return redirect()->route('user-management.document-management.index', $userId);

        } catch (\Throwable $th) {
            return back()->with('toast_error', $th->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $userId, string $documentId)
    {
        $categories = ThesisCategory::all();

        $document = Thesis::find($documentId);

        $user = User::find($userId);

        if(!$document) return redirect()->route('user-management.document-management.index', $userId);

        return view('admin_views.users.documents.user_document_upsert_form', compact('categories', 'document', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $userId, string $documentId)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable',
            'abstract' => 'nullable',
            'category' => 'nullable',
            'file' => 'nullable|mimes:pdf|max:15360'
        ]);

        if($validator->fails()){
            return back()
            ->withInput()
            ->with('toast_error', join(', ', $validator->messages()->all()));
        }

        try {
            $oldData = Thesis::find($documentId);
            
            if(!$oldData) return redirect()->route('my-document.index')->with('toast_error', 'Document Not Found');
            
            $newData = [];
            if($validator->safe()->title){
                $newData['title'] = $validator->safe()->title;
            }
            if($validator->safe()->abstract){
                $newData['abstract'] = $validator->safe()->abstract;
            }
            if($validator->safe()->category){
                $newData['id_category'] = $validator->safe()->category;
            }

            if($request->file){
                // store new file
                $file = $request->file;
                $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
                $newData['file_name'] = $fileName;
                $file->storeAs('document/', $fileName);

                // Delete old file
                Storage::delete('document/'.$oldData->file_name);
            }

            $oldData->update($newData);

            Session::flash('toast_success', 'Document updated');
            return redirect()->route('user-management.document-management.index', $userId);

        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('toast_error', $th->getMessage())->withInput();
        }    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $userId, string $documentId)
    {
        try {
            $thesis = Thesis::find($documentId);

            if(!$thesis) return redirect()->route('my-document.index')->with('toast_error', 'Document Not Found');

            Storage::delete('document/'.$thesis->file_name);

            $thesis->delete();

            return redirect()->route('user-management.document-management.index', $userId)->with('toast_success', 'Document deleted');
        } catch (\Throwable $th) {
            return back()
            ->with('toast_error', $th->getMessage());
        }    }
}
