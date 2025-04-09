<?php

namespace App\Http\Controllers;

use App\Models\ThesisCategory;
use App\Models\ThesisType;
use App\Support\Interfaces\Services\ThesisTopicServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ThesisTopicController extends Controller
{
    public function __construct(
        protected ThesisTopicServiceInterface $thesisTopicService,
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topics = $this->thesisTopicService->getThesisTopics();

        return view('admin_views.thesis-topic.index', ['topics' => $topics]);
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
            'topic' => 'required|string|unique:thesis_topics,topic',
        ], [
            'topic.required' => "Topik Wajib Diisi",
            'topic.unique' => "Topik :input telah ditambahkan",
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', join(', ', $validator->messages()->all()));
        }

        try {
            $data = $validator->safe()->all();

            $newTopic = $this->thesisTopicService->storeThesisTopic($data);

            return redirect()->back()->with('toast_success', 'Data Topik Ditambahkan');
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
            'topic' => ['nullable', 'string', Rule::unique('thesis_topics')->ignore($ID)],
        ], [
            'topic.unique' => "Topik :input telah ditambahkan",
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', join(', ', $validator->messages()->all()));
        }

        try {
            $data = $validator->safe()->all();

            $isSuccess = $this->thesisTopicService->updateThesisTopic($ID, $data);

            if (!$isSuccess) return redirect()->back();

            return redirect()->back()->with('toast_success', 'Data Topik Diperbarui');
        } catch (\Throwable $th) {
            return back()
                ->with('toast_error', 'Gagal Memperbarui Data Topik');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ID)
    {
        try {
            $isSuccess = $this->thesisTopicService->deleteThesisTopic($ID);

            if (!$isSuccess) return redirect()->back();

            return redirect()->back()->with('toast_success', 'Data Topik Dihapus');
        } catch (\Throwable $th) {
            return back()
                ->with('toast_error', 'Gagal Menghapus Data Topik');
        }
    }
}
