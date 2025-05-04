<?php

namespace App\Http\Controllers;

use App\Support\Interfaces\Services\LecturerServiceInterface;
use App\Support\Interfaces\Services\ThesisTopicServiceInterface;
use App\Support\model\GetLecturerReqModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LecturerManagementController extends Controller
{
    public function __construct(
        protected  LecturerServiceInterface $lecturerService,
        protected  ThesisTopicServiceInterface $thesisTopicService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reqModel = new GetLecturerReqModel($request);

        $lecturers = $this->lecturerService->getLecturers($reqModel);
        $topics = $this->thesisTopicService->getThesisTopics();

        return view('admin_views.lecturer.index', compact('lecturers', 'topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $topics = $this->thesisTopicService->getThesisTopics();

        return view('admin_views.lecturer.lecturer_upsert_form', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:lecturers,username',
            'name' => 'required',
            'topic_id' => 'required',
            'email' => 'required|email|unique:lecturers,email',
            'password' => 'required|min:6',
            'profile_picture' => 'nullable|mimes:png,jpg,jpeg|max:1024',
        ], [
            'username.unique' => 'Username Sudah Digunakan',
            'username.required' => 'Username Wajib Diisi',
            'name.required' => 'Nama Wajib Diisi',
            'topic_id.required' => 'Topik Wajib Diisi',
            'email.unique' => 'Email Sudah Digunakan',
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'Password Wajib Diisi',
        ]);

        if ($validator->fails()) return redirect()
            ->back()
            ->withInput()
            ->with('toast_error', join(', ', $validator->messages()->all()));

        try {
            $data = $validator->safe()->all();

            $this->lecturerService->storeLecturer($data);

            return redirect()->route('lecturer-management.index')->with('toast_success', 'Data Dosen Ditambahkan');
        } catch (\Throwable $th) {
            return redirect()
                ->route('lecturer-management.create')
                ->withInput()
                ->with('toast_error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ID)
    {
        $lecturer = $this->lecturerService->getLecturerByID($ID);

        if (!isset($lecturer)) return back()->with('toast_error', "Data Dosen Tidak Ditemukan");

        return view('admin_views.lecturer.lecturer_detail', compact('lecturer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $ID)
    {
        $topics = $this->thesisTopicService->getThesisTopics();

        $lecturer = $this->lecturerService->getLecturerByID($ID);

        if (!$lecturer) return redirect()->back()->with('toast_error', 'Data Dosen Tidak Ditemukan');

        return view('admin_views.lecturer.lecturer_upsert_form', compact('topics', 'lecturer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $ID)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'nullable|unique:lecturers,username',
            'name' => 'nullable',
            'topic_id' => 'nullable',
            'email' => 'nullable|email|unique:lecturers,email',
            'password' => 'nullable|min:6',
            'profile_picture' => 'nullable|mimes:png,jpg,jpeg|max:1024',
        ], [
            'username.unique' => 'Username Sudah Digunakan',
            'email.unique' => 'Email Sudah Digunakan',
        ]);

        if ($validator->fails()) return redirect()
            ->back()
            ->withInput()
            ->with('toast_error', join(', ', $validator->messages()->all()));

        try {
            $data = $validator->safe()->all();

            $isSuccess = $this->lecturerService->updateLecturer($ID, $data);

            if (!$isSuccess) redirect()
                ->back()
                ->withInput()
                ->with('toast_error', "Gagal Memperbarui Data Dosen");

            return redirect()->route('lecturer-management.index')->with('toast_success', 'Data Dosen Diperbarui');
        } catch (\Throwable $th) {
            return redirect()
                ->route('lecturer-management.create')
                ->withInput()
                ->with('toast_error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ID)
    {
        try {
            $this->lecturerService->deleteLecturer($ID);

            return redirect()->route('lecturer-management.index')->with('toast_success', 'Data Dosen Dihapus');
        } catch (\Throwable $th) {
            return back()
                ->with('toast_error', $th->getMessage());
        }
    }


    public function getLecturerImportTemplate()
    {
        return response()->download(public_path('template/Template_Dosen.xlsx'), 'Template_Dosen.xlsx');
    }


    public function importLecturerExcelData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'import_file' => 'required|mimes:xlsx',
            'topic_id' => 'required',
        ], [
            'import_file.required' => 'File Template Wajib Diisi',
            'topic_id.required' => 'Topic Wajib Dipilih',
        ]);

        if ($validator->fails()) return redirect()
            ->back()
            ->withInput()
            ->with('toast_error', join(', ', $validator->messages()->all()));

        try {
            $data = $validator->safe()->all();


            $topicID = $data['topic_id'];
            $file = $data['import_file'];

            $this->lecturerService->importExcel($topicID, $file);

            return back()->with('toast_success', 'Impor Berhasil');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Gagal Menambahkan Data');
        }
    }
}
