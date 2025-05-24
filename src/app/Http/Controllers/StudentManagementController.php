<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Support\Interfaces\Services\ProgramStudyServiceInterface;
use App\Support\Interfaces\Services\StudentServiceInterface;
use App\Support\model\GetStudentReqModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class StudentManagementController extends Controller
{

    public function __construct(
        protected  StudentServiceInterface $studentService,
        protected  ProgramStudyServiceInterface $prodyService,
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reqModel = new GetStudentReqModel($request);

        $students = $this->studentService->getStudents($reqModel);

        $prodys = $this->prodyService->getProgramStudys();

        return view('admin_views.student.index', compact('students', 'prodys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodys = $this->prodyService->getProgramStudys();

        return view('admin_views.student.student_upsert_form', compact('prodys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:students,username',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required|in:Male,Female',
            'class_year' => 'required|numeric',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|min:6',
            'program_study_id' => 'required',
            'profile_picture' => 'nullable|mimes:png,jpg,jpeg|max:1024',
        ], [
            'username.unique' => 'Username Sudah Digunakan',
            'username.required' => 'Username Wajib Diisi',
            'first_name.required' => 'Nama Depan Wajib Diisi',
            'last_name.required' => 'Nama Belakang Wajib Diisi',
            'gender.required' => 'Jenis Kelamin Wajib Diisi',
            'class_year.required' => 'Tahun Angkatan Wajib Diisi',
            'email.unique' => 'Email Sudah Digunakan',
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'Password Wajib Diisi',
            'program_study_id.required' => 'Program Studi Wajib Diisi',
        ]);

        if ($validator->fails()) return redirect()
            ->back()
            ->withInput()
            ->with('toast_error', join(', ', $validator->messages()->all()));

        try {
            $data = $validator->safe()->all();

            $this->studentService->storeStudent($data);

            return redirect()->route('student-management.index')->with('toast_success', 'Data Mahasiswa Ditambahkan');
        } catch (\Throwable $th) {
            return redirect()
                ->route('student-management.create')
                ->withInput()
                ->with('toast_error', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $ID)
    {
        $prodys = $this->prodyService->getProgramStudys();

        $student = $this->studentService->getStudentByID($ID);

        if (!$student) return redirect()->back()->with('toast_error', 'Data Mahasiswa Tidak Ditemukan');

        return view('admin_views.student.student_upsert_form', compact('prodys', 'student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $ID)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'nullable|unique:students,username,' . $ID . 'id',
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'gender' => 'nullable|in:Male,Female',
            'class_year' => 'nullable|numeric',
            'email' => 'nullable|email|unique:students,email,' . $ID . 'id',
            'password' => 'nullable|min:6',
            'program_study_id' => 'nullable',
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

            $this->studentService->updateStudent($ID, $data);

            return redirect()->route('student-management.index')->with('toast_success', 'Data Mahasiswa Diperbarui');
        } catch (\Throwable $th) {
            return redirect()
                ->route('student-management.index')
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
            $this->studentService->deleteStudent($ID);

            return redirect()->route('student-management.index')->with('toast_success', 'Data Mahasiswa Dihapus');
        } catch (\Throwable $th) {
            return back()
                ->with('toast_error', $th->getMessage());
        }
    }

    public function show(string $ID)
    {
        $student = $this->studentService->getStudentByID($ID);

        if (!isset($student)) return back()->with('toast_error', "Data Mahasiswa Tidak Ditemukan");

        return view('admin_views.student.student_detail', compact('student'));
    }

    public function importStudentExcelData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'import_file' => 'required|mimes:xlsx',
            'program_study_id' => 'required',
        ], [
            'import_file.required' => 'File Template Wajib Diisi',
            'program_study_id.required' => 'Program Studi Wajib Dipilih',
        ]);

        if ($validator->fails()) return redirect()
            ->back()
            ->withInput()
            ->with('toast_error', join(', ', $validator->messages()->all()));

        try {
            $data = $validator->safe()->all();


            $prodyID = $data['program_study_id'];
            $file = $data['import_file'];

            $this->studentService->importExcel($prodyID, $file);

            return back()->with('toast_success', 'Impor Berhasil');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Gagal Menambahkan Data');
        }
    }

    public function getStudentImportTemplate()
    {
        return response()->download(public_path('template/Template_Mahasiswa.xlsx'), 'Template_Mahasiswa.xlsx');
    }

    public function exportStudentsData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_class_year' => 'nullable',
            'program_study_id' => 'nullable',
            'submission_status' => 'nullable',
            'export_format' => 'required|in:excel,pdf',
        ], [
            'export_format.required' => 'Format ekspor wajib disertakan',
            'export_format.in' => 'Format ekspor tidak valid',
        ]);

        if ($validator->fails()) return redirect()
            ->back()
            ->withInput()
            ->with('toast_error', join(', ', $validator->messages()->all()));

        $reqModel = new GetStudentReqModel($request);

        $students = $this->studentService->getStudents($reqModel, null);

        $processedData = collect();
        foreach ($students as $value) {
            $data = [
                "username" => $value->username,
                "name" => $value->first_name . " " . $value->last_name,
                "program_study" => $value->programStudy->name,
            ];

            if (!$value->thesis) {
                $submissionStatus = 'Belum Dikumpulkan';
            } else if (!isset($value->thesis->submission_status)) {
                $submissionStatus = 'Pending';
            } else {
                $submissionStatus = $value->thesis->submission_status ? "Diterima" : "Ditolak";
            }

            $data["submission_status"] = $submissionStatus;

            $processedData->push($data);
        }

        if ($request->export_format == 'excel') {
            return Excel::download(new StudentsExport($processedData), 'data-tugas-akhir-mahasiswa.xlsx');
        } else {
            $mpdf = new Mpdf();
            $mpdf->WriteHTML(view("pdf.students-data-export", ['students' => $processedData]));
            $mpdf->Output('data-status-tugas-akhir-mhs.pdf', 'D');
        }
    }
}
