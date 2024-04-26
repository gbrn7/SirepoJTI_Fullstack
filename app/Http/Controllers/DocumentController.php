<?php

namespace App\Http\Controllers;

use App\Models\Thesis;
use App\Models\User;
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

    public function userDocument(Request $request, string $id)
    {
        $user = User::with('programStudy.majority')->find($id);

        if(!$user) return redirect()->route('home')->with('toast_error', 'User Not Found');

        $document = $user
                    ->document()
                    ->when($request->only('title'), function($query) use ($request){
                        return $query->where('title', 'like', '%'.$request->title.'%');
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(10);

        return view('public_views.user_document', compact('user', 'document'));        
    }

    public function getSuggestionTitle( Request $request, string $userId)
    {
        $titles = Thesis::select('title', 'id_user')
                ->where('title', 'like', '%'.$request->title.'%')
                ->where('id_user', $userId)
                ->get();

        return response()->json($titles);
    }
}
