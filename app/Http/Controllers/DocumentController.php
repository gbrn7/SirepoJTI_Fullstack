<?php

namespace App\Http\Controllers;

use App\Models\Thesis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function detailDocument($id)
    {
        $document = Thesis::with('user.programStudy.majority')->find($id);

        if(!$document) return back()->with('toast_error', 'Document Not Found');

        return view('public_views.detail_document', ['document' => $document]);
    }

    public function downloadDocument($id)
    {
        $document = Thesis::with('user.programStudy.majority')->find($id);

        if(!$document) return redirect()->route('home')->with('toast_error', 'Document Not Found');

        // Donwload PDF
        // return Storage::download('public/Document/'.$document->file_name);
        // Get document from storage
        // return Storage::get('Document/'.$document->file_name);
        
        // Stream PDF
        return response()->file('storage/Document/'.$document->file_name);
    }
}
