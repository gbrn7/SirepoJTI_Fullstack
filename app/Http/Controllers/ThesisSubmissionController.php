<?php

namespace App\Http\Controllers;

use App\Models\lecturer;
use App\Models\Thesis;
use App\Models\ThesisTopic;
use App\Models\ThesisType;
use App\Support\Interfaces\Services\ThesisServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class ThesisSubmissionController extends Controller
{
    public function __construct(
        protected ThesisServiceInterface $thesisService,
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentID = Auth::user()->id;
        $document = $this->thesisService->getDetailDocumentByStudentID($studentID);
        return view('user_views.thesis_submission', ['document' => $document]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $topics = ThesisTopic::all();

        $types = ThesisType::all();

        $lecturers = Lecturer::all();

        return view('user_views.thesis_document_form', compact('topics', 'types', 'lecturers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'abstract' => 'required',
            'topic_id' => 'required',
            'type_id' => 'required',
            'lecturer_id' => 'required',
            'required_file' => 'required|mimes:pdf|max:15360',
            'abstract_file' => 'nullable|mimes:pdf|max:15360',
            'list_of_content_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_1_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_2_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_3_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_4_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_5_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_6_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_7_file' => 'nullable|mimes:pdf|max:15360',
            'bibliography_file' => 'nullable|mimes:pdf|max:15360',
            'attachment_file' => 'nullable|mimes:pdf|max:15360',
        ], [
            'title.required' => 'Judul Wajib Diisi',
            'abstract.required' => 'Abstrak Wajib Diisi',
            'topic_id.required' => 'Pilihlah Tipe Tugas Akhir',
            'type_id.required' => 'Pilihlah Tipe Tugas Akhir',
            'lecturer_id.required' => 'Pilihlah Dosen Pembimbing',
            'required_file.required' => 'Dokumen Lengkap Tugas Akhir Wajib Diisi',
        ]);
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->with('toast_error', join(', ', $validator->messages()->all()));
        }

        try {
            $data = $validator->safe()->all();

            $files = $request->file();

            $userID = auth()->user()->id;

            $this->thesisService->storeThesis($userID, $data, $files);

            Session::flash('toast_success', 'Tugas Akhir Ditambahkan');
            return redirect()->route('thesis-submission.index');
        } catch (\Throwable $th) {
            return back()->with('toast_error', $th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $document = Thesis::with('user.programStudy.majority')
            ->with('category')
            ->find($id);

        if (!$document) return back()->with('toast_error', 'Document Not Found');

        return view('user_views.my_detail_document', ['document' => $document]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $topics = ThesisTopic::all();

        $types = ThesisType::all();

        $lecturers = Lecturer::all();

        $document = Thesis::find($id);

        if (!$document) return back()->with('toast_error', 'Document Not Found');

        return view('user_views.thesis_document_form', compact('topics', 'document', 'types', 'lecturers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $ID)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable',
            'abstract' => 'nullable',
            'topic_id' => 'nullable',
            'type_id' => 'nullable',
            'lecturer_id' => 'nullable',
            'required_file' => 'nullable|mimes:pdf|max:15360',
            'abstract_file' => 'nullable|mimes:pdf|max:15360',
            'list_of_content_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_1_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_2_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_3_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_4_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_5_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_6_file' => 'nullable|mimes:pdf|max:15360',
            'chapter_7_file' => 'nullable|mimes:pdf|max:15360',
            'bibliography_file' => 'nullable|mimes:pdf|max:15360',
            'attachment_file' => 'nullable|mimes:pdf|max:15360',
        ]);


        if ($validator->fails()) {
            return back()
                ->withInput()
                ->with('toast_error', join(', ', $validator->messages()->all()));
        }



        try {
            $this->thesisService->updateThesis($validator->safe()->toArray(), $ID, $request->file());

            Session::flash('toast_success', 'Tugas Akhir Diedit');
            return redirect()->route('thesis-submission.index');
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

            if (!$thesis) return redirect()->route('thesis-submission.index')->with('toast_error', 'Document Not Found');

            Storage::delete('document/' . $thesis->file_name);

            $thesis->delete();

            return redirect()->route('thesis-submission.index')->with('toast_success', 'Document deleted');
        } catch (\Throwable $th) {
            return back()
                ->with('toast_error', $th->getMessage());
        }
    }
}
