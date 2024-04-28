<?php

namespace App\Http\Controllers;

use App\Models\ThesisCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ThesisCategory::orderBy('id', 'desc')->get();

        return view('admin_views.category.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|unique:thesis_category,category',
        ]);

        if($validator->fails()){
            return back()
            ->with('toast_error', join(', ', $validator->messages()->all()));
        }
        
        try {
            ThesisCategory::create($validator->safe()->only('category'));

            return redirect()->back()->with('toast_success', 'Category Created');
        } catch (\Throwable $th) {
            return back()
            ->with('toast_error', $th->getMessage()[0]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'category' => 'required|string|unique:thesis_category,category,'.$id.',id',
        ]);

        if($validator->fails()){
            return back()
            ->with('toast_error', join(', ', $validator->messages()->all()));
        }
        
        try {
            $thesis = ThesisCategory::find($id);

            if(!$thesis) return redirect()->back()->with('toast_error', 'category Not Found');

            $thesis->update($validator->safe()->only('category'));

            return redirect()->back()->with('toast_success', 'Category Updated');
        } catch (\Throwable $th) {
            return back()
            ->with('toast_error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $thesis = ThesisCategory::find($id);

            if(!$thesis) return redirect()->route('categories.index')->with('toast_error', 'category Not Found');

            $thesis->delete();

            return redirect()->route('categories.index')->with('toast_success', 'Category deleted');
        } catch (\Throwable $th) {
            return back()
            ->with('toast_error', 'The category thesis is referenced by other data');
        }
    }
}
