<?php

namespace App\Http\Controllers;


use App\Support\Interfaces\Services\ThesisTypeServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ThesisTypeController extends Controller
{
    public function __construct(
        protected ThesisTypeServiceInterface $thesisTypeService,
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = $this->thesisTypeService->getThesisTypes();

        return view('admin_views.thesis-type.index', ['types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
        ], [
            'type.required' => "Data Jenis Tugas Akhir Wajib Diisi",
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', join(', ', $validator->messages()->all()));
        }

        try {
            $data = $validator->safe()->all();

            $this->thesisTypeService->storeThesisType($data);

            return redirect()->back()->with('toast_success', 'Data Jenis Tugas Akhir Ditambahkan');
        } catch (\Throwable $th) {
            return back()
                ->with('toast_error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $ID)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['nullable', 'string', Rule::unique('thesis_types')->ignore($ID)],
        ], [
            'type.unique' => "Data Jenis Tugas Akhir :input Telah Ditambahkan",
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', join(', ', $validator->messages()->all()));
        }

        try {
            $data = $validator->safe()->all();

            $isSuccess = $this->thesisTypeService->updateThesisType($ID, $data);

            if (!$isSuccess) return redirect()->back();

            return redirect()->back()->with('toast_success', 'Data Jenis Tugas Akhir Diperbarui');
        } catch (\Throwable $th) {
            return back()
                ->with('toast_error', 'Gagal Memperbarui Data Jenis Tugas Akhir');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ID)
    {
        try {
            $isSuccess = $this->thesisTypeService->deleteThesisType($ID);

            if (!$isSuccess) return redirect()->back();

            return redirect()->back()->with('toast_success', 'Data Jenis Tugas Akhir Dihapus');
        } catch (\Throwable $th) {
            return back()
                ->with('toast_error', 'Gagal Menghapus Data Jenis Tugas Akhir');
        }
    }
}
