<?php

namespace App\Http\Controllers;

use App\Models\Thesis;
use App\Models\ThesisCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MyDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $documenClass = new DocumentController;

        $data = $documenClass->getUserDocument(Auth::user()->id, $request);

        if($data instanceof RedirectResponse ) return $data;

        return view('user_views.my_document', $data); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ThesisCategory::all();

        return view('user_views.user_document_form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            $data['id_user'] = Auth::user()->id;

            Thesis::create($data);

            Session::flash('toast_success', 'Document Added');
            return redirect()->route('my-document.index');

        } catch (\Throwable $th) {
            return back()->with('toast_error', $th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $document = Thesis::with('user.programStudy.majority')->find($id);

        if(!$document) return back()->with('toast_error', 'Document Not Found');

        return view('user_views.my_detail_document', ['document' => $document]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = ThesisCategory::all();

        $document = Thesis::find($id);

        if(!$document) return back()->with('toast_error', 'Document Not Found');

        return view('user_views.user_document_form', compact('categories', 'document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
            $oldData = Thesis::find($id);
            
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
            return redirect()->route('my-document.index');

        } catch (\Throwable $th) {
            return back()->with('toast_error', $th->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $thesis = Thesis::find($id);

            if(!$thesis) return redirect()->route('my-document.index')->with('toast_error', 'Document Not Found');

            Storage::delete('document/'.$thesis->file_name);

            $thesis->delete();

            return redirect()->route('my-document.index')->with('toast_success', 'Document deleted');
        } catch (\Throwable $th) {
            return back()
            ->with('toast_error', $th->getMessage());
        }
    }
}
