<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Thesis;
use App\Support\Enums\SubmissionStatusEnum;
use App\Support\Interfaces\Services\LecturerServiceInterface;
use App\Support\Interfaces\Services\ProgramStudyServiceInterface;
use App\Support\Interfaces\Services\StudentServiceInterface;
use App\Support\Interfaces\Services\ThesisServiceInterface;
use App\Support\Interfaces\Services\ThesisTopicServiceInterface;
use App\Support\Interfaces\Services\ThesisTypeServiceInterface;
use App\Support\model\GetThesisReqModel;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DocumentController extends Controller
{

    public function __construct(
        protected ThesisServiceInterface $thesisService,
        protected  ProgramStudyServiceInterface $programStudyService,
        protected  ThesisTopicServiceInterface $thesisTopicService,
        protected  ThesisTypeServiceInterface $thesisTypeService,
        protected  LecturerServiceInterface $lecturerService,
        protected  StudentServiceInterface $studentService,
    ) {}

    public function index(Request $request): View
    {
        $reqModel = new GetThesisReqModel($request);

        $documents = $this->thesisService->getThesis($reqModel);

        $prodys = $this->programStudyService->getProgramStudys();

        return view('admin_views.documents.index', ['documents' => $documents, 'prodys' => $prodys]);
    }

    public function create()
    {
        $topics = $this->thesisTopicService->getThesisTopics();

        $types = $this->thesisTypeService->getThesisTypes();

        $lecturers = $this->lecturerService->getLecturers();

        return view('admin_views.documents.document_upsert_form', compact('topics', 'types', 'lecturers'));
    }

    public function edit(string $id)
    {
        $topics = $this->thesisTopicService->getThesisTopics();

        $types = $this->thesisTypeService->getThesisTypes();

        $lecturers = $this->lecturerService->getLecturers();

        $thesis = $this->thesisService->getThesisByID($id);

        if (!$thesis) return back()->with('toast_error', 'Tugas akhir tidak ditemukan');

        return view('admin_views.documents.document_upsert_form', compact('topics', 'types', 'lecturers', 'thesis'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'title' => 'required',
            'abstract' => 'required',
            'topic_id' => 'required',
            'type_id' => 'required',
            'lecturer_id' => 'required',
            'required_file' => 'required|mimes:pdf|max:16384',
            'abstract_file' => 'nullable|mimes:pdf|max:16384',
            'list_of_content_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_1_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_2_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_3_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_4_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_5_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_6_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_7_file' => 'nullable|mimes:pdf|max:16384',
            'bibliography_file' => 'nullable|mimes:pdf|max:16384',
            'attachment_file' => 'nullable|mimes:pdf|max:16384',
        ], [
            'username.required' => 'Username Wajib Diisi',
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

            $student = $this->studentService->getStudentByUsername($data['username']);

            if (!isset($student)) {
                return back()->with('toast_error', 'Username tidak ditemukan');
            }

            $thesis = $this->thesisService->getDetailDocumentByStudentID($student->id);

            if ($thesis) {
                return back()->with('toast_error', 'Gagal Menyimpan Data, Tugas Akhir Telah Ditambahkan Sebelumnya!!');
            }

            $this->thesisService->storeThesis($student->id, $data, $files);

            Session::flash('toast_success', 'Tugas Akhir Ditambahkan');
            return redirect()->route('documents-management.index');
        } catch (\Throwable $th) {
            return back()->with('toast_error', $th->getMessage())->withInput();
        }
    }

    public function update(Request $request, string $ID)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'nullable',
            'submission_status' => 'nullable',
            'title' => 'nullable',
            'note' => 'nullable',
            'abstract' => 'nullable',
            'topic_id' => 'nullable',
            'type_id' => 'nullable',
            'lecturer_id' => 'nullable',
            'required_file' => 'nullable|mimes:pdf|max:16384',
            'abstract_file' => 'nullable|mimes:pdf|max:16384',
            'list_of_content_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_1_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_2_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_3_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_4_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_5_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_6_file' => 'nullable|mimes:pdf|max:16384',
            'chapter_7_file' => 'nullable|mimes:pdf|max:16384',
            'bibliography_file' => 'nullable|mimes:pdf|max:16384',
            'attachment_file' => 'nullable|mimes:pdf|max:16384',
        ]);
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->with('toast_error', join(', ', $validator->messages()->all()));
        }

        try {
            $data = $validator->safe()->all();

            $files = $request->file();

            if (isset($data['username'])) {
                $student = $this->studentService->getStudentByUsername($data['username']);

                if (!isset($student)) {
                    return back()->with('toast_error', 'Username tidak ditemukan');
                }

                $data['student_id'] = $student->id;
            }

            if (isset($data['submission_status'])) {
                switch ($data['submission_status']) {
                    case SubmissionStatusEnum::ACCEPTED->value:
                        $data['submission_status'] = true;
                        $data['note'] = "";
                        break;
                    case SubmissionStatusEnum::DECLINED->value:
                        $data['submission_status'] = false;
                        break;
                    default:
                        $data['submission_status'] = null;
                        break;
                }
            }
            $this->thesisService->updateThesis($data, $ID, $files);

            Session::flash('toast_success', 'Tugas Akhir Diperbarui');
            return redirect()->route('documents-management.index');
        } catch (\Throwable $th) {
            return back()->with('toast_error', $th->getMessage())->withInput();
        }
    }

    public function destroy(string $ID)
    {
        try {
            $isSuccess = $this->thesisService->destroyThesisByID($ID);

            if (!$isSuccess) throw new Exception("Internal server error");

            return redirect()->route('documents-management.index')->with('toast_success', 'Tugas akhir berhasil dihapus');
        } catch (\Throwable $th) {
            return back()
                ->with('toast_error', $th->getMessage());
        }
    }

    public function show(string $ID)
    {
        $document = $this->thesisService->getDetailDocument($ID);

        if (!$document) return back()->with('toast_error', 'Document Not Found');

        return view('admin_views.documents.detail_document', ['document' => $document]);
    }

    public function detailDocument($ID)
    {
        $document = $this->thesisService->getDetailDocument($ID);

        if (!$document) return redirect()->route('home')->with('toast_error', 'Document Tidak Ditemukan');

        if (Auth::guard('student')->check() && Auth::user()->id != $document->student_id) {
            if (!$document) return redirect()->route('home')->with('toast_error', 'Document Not yet verified');
        }

        return view('public_views.detail_document', ['document' => $document]);
    }

    public function downloadDocument(string $fileName)
    {
        // Get document from storage
        $file = $this->thesisService->downloadDocument($fileName);
        if (!$file) return back()->with('toast_error', 'Document Not Found');

        $response = Response::make($file, 200);
        $response->header('Content-Type', 'application/pdf');
        $response->header('Content-disposition', 'inline; filename="' . $fileName . '.pdf"');

        return $response;

        // Stream PDF
        // return response()->file('storage/Document/'.$fileName);
    }

    public function userDocument(Request $request, string $ID)
    {
        $data = $this->getUserDocument($ID, $request);

        if ($data instanceof RedirectResponse) return $data;

        return view('public_views.user_document', $data);
    }

    public function getSuggestionTitle(Request $request, string $userId)
    {
        $titles = Thesis::select('title', 'id_user')
            ->where('title', 'like', '%' . $request->title . '%')
            ->where('id_user', $userId)
            ->get();

        return response()->json($titles);
    }


    public function getUserDocument(string $ID, Request $request)
    {
        $student = Student::with('programStudy.majority')->find($ID);

        if (!$student) return redirect()->route('home')->with('toast_error', 'User Not Found');

        $document = Thesis::where('student_id', $student->id)
            ->with('topic')
            ->when($request->title, function ($query) use ($request) {
                return $query->where('title', 'like', '%' . $request->title . '%');
            })
            ->orderBy('thesis.id', 'desc')
            ->paginate(10);

        return compact('student', 'document');
    }

    public function bulkUpdateSubmissionStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'thesisIDs' => 'required|array',
            'note' => 'nullable|string',
            'submission_status' => 'required|in:' . SubmissionStatusEnum::ACCEPTED->value . ',' .
                SubmissionStatusEnum::PENDING->value . ',' . SubmissionStatusEnum::DECLINED->value . '',
        ], [
            'thesisIDs.required' => 'ID Tugas Akhir Wajib Dikirimkan',
            'thesisIDs.array' => 'ID Tugas Akhir Harus bertipe array',
            'submission_status.required' => 'Status Tugas Akhir Wajib Dikirimkan',
            'submission_status.in' => 'Status Yang dikirim tidak valid',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->with('toast_error', join(', ', $validator->messages()->all()));
        }


        try {
            $data = $validator->safe()->all();
            $note = isset($data['note']) ? $data['note'] : '';

            $this->thesisService->bulkUpdateSubmissionStatus($data['thesisIDs'], $data['submission_status'], $note);

            Session::flash('toast_success', 'Tugas Akhir Diperbarui');
            return redirect()->route('documents-management.index');
        } catch (\Throwable $th) {
            return back()->with('toast_error', $th->getMessage())->withInput();
        }
    }
}
