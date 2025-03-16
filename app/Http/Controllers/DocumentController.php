<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Thesis;
use App\Models\ThesisCategory;
use App\Models\ThesisFile;
use App\Models\ThesisType;
use App\Models\ThesisTypes;
use App\Models\User;
use App\Support\Interfaces\Services\ThesisServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DocumentController extends Controller
{

    public function __construct(
        protected ThesisServiceInterface $thesisService,
    ) {}

    public function index(Request $request)
    {
        $documents = Thesis::with('topic')
            ->with('student.programStudy.majority')
            ->when($request->title, function ($query) use ($request) {
                return $query->where('title', 'like', '%' . $request->title . '%');
            })
            ->orderBy('thesis.id', 'desc')
            ->paginate(10);

        return view('admin_views.documents.index', ['documents' => $documents]);
    }

    public function create()
    {
        $categories = ThesisType::all();

        return view('admin_views.documents.document_upsert_form', compact('categories'));
    }

    public function edit(string $id)
    {
        $categories = ThesisType::all();

        $document = Thesis::find($id);

        if (!$document) return back()->with('toast_error', 'Document Not Found');

        return view('admin_views.documents.document_upsert_form', compact('categories', 'document'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'title' => 'required',
            'abstract' => 'required',
            'category' => 'required',
            'file' => 'required|mimes:pdf|max:15360'
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->with('toast_error', join(', ', $validator->messages()->all()));
        }

        try {
            $data = $validator->safe()->all();

            $user = Student::where('username', $request->username)->first();

            if (!$user) return back()->withInput()->with('toast_error', 'Username Not Found');

            // store file
            $file = $request->file;
            $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('document/', $fileName);

            $data['file_name'] = $fileName;
            $data['id_category'] = $data['category'];
            $data['id_user'] = $user->id;

            Thesis::create($data);

            Session::flash('toast_success', 'Document Added');
            return redirect()->route('documents-management.index');
        } catch (\Throwable $th) {
            return back()->with('toast_error', $th->getMessage())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable',
            'abstract' => 'nullable',
            'category' => 'nullable',
            'file' => 'nullable|mimes:pdf|max:15360',
            'username' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->with('toast_error', join(', ', $validator->messages()->all()));
        }

        try {
            $oldData = Thesis::find($id);

            if (!$oldData) return  back()->withInput()->with('toast_error', 'Document Not Found');

            $newData = [];
            if ($validator->safe()->title) {
                $newData['title'] = $validator->safe()->title;
            }
            if ($validator->safe()->abstract) {
                $newData['abstract'] = $validator->safe()->abstract;
            }
            if ($validator->safe()->category) {
                $newData['id_category'] = $validator->safe()->category;
            }
            if ($validator->safe()->username) {
                $user = Student::where('username', $request->username)->first();

                if (!$user) return back()->withInput()->with('toast_error', 'Username Not Found');

                $newData['id_user'] = $user->id;
            }

            if ($request->file) {
                // store new file
                $file = $request->file;
                $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();
                $newData['file_name'] = $fileName;
                $file->storeAs('document/', $fileName);

                // Delete old file
                Storage::delete('document/' . $oldData->file_name);
            }

            $oldData->update($newData);

            Session::flash('toast_success', 'Document updated');
            return redirect()->route('documents-management.index');
        } catch (\Throwable $th) {
            return back()->with('toast_error', $th->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $thesis = Thesis::find($id);

            if (!$thesis) return redirect()->route('documents-management.index')->with('toast_error', 'Document Not Found');

            Storage::delete('document/' . $thesis->file_name);

            $thesis->delete();

            return redirect()->route('documents-management.index')->with('toast_success', 'Document deleted');
        } catch (\Throwable $th) {
            return back()
                ->with('toast_error', $th->getMessage());
        }
    }

    public function show(string $id)
    {
        $document = Thesis::with('user.programStudy.majority')
            ->with('category')
            ->find($id);

        if (!$document) return back()->with('toast_error', 'Document Not Found');

        return view('admin_views.documents.detail_document', ['document' => $document]);
    }

    public function detailDocument($ID)
    {
        $document = $this->thesisService->getDetailDocument($ID);

        if (!$document) return redirect()->route('home')->with('toast_error', 'Document Not Found');

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

    public function userDocument(Request $request, string $id)
    {
        $data = $this->getUserDocument($id, $request);

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


    public function getUserDocument(string $id, Request $request)
    {
        $student = Student::with('programStudy.majority')->find($id);

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
}
