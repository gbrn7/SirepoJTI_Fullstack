<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudy;
use App\Models\Student;
use App\Models\Thesis;
use App\Models\ThesisTopic;
use App\Models\ThesisType;
use App\Support\Interfaces\Services\ThesisServiceInterface;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct(
        protected ThesisServiceInterface $thesisService
    ) {}

    public function welcomeView(): View
    {
        return view('public_views.welcome');
    }

    public function homeView(Request $request): View
    {
        $searchParams = [
            'title' => $request->title,
            'program_study_id' => $request->program_study_id,
            'topic_id' => $request->topic_id,
            'type_id' => $request->type_id,
            'name' => $request->author,
            'publication_from' => $request->publication_from ? Carbon::createFromDate($request->publication_from, 1)->startOfYear() : null,
            'publication_until' => $request->publication_until ? Carbon::createFromDate($request->publication_until, 1)->endOfYear() : null,
        ];


        $documents = DB::table('thesis as t')
            ->where('t.title', 'like', '%' . $searchParams['title'] . '%')
            ->when($searchParams['topic_id'], function ($query) use ($searchParams) {
                return $query->whereIn('tt.topic_id', $searchParams['topic_id']);
            })
            ->when($searchParams['type_id'], function ($query) use ($searchParams) {
                return $query->whereIn('tte.id', $searchParams['type_id']);
            })
            ->when($searchParams['program_study_id'], function ($query) use ($searchParams) {
                return $query->whereIn('s.program_study_id', $searchParams['program_study_id']);
            })
            ->when($searchParams['name'], function ($query) use ($searchParams) {
                return $query
                    ->where('s.first_name', $searchParams['name'])
                    ->orWhere('s.last_name', $searchParams['name']);
            })
            ->when($searchParams['publication_from'], function ($query) use ($searchParams) {
                return $query->where('t.created_at', '>=', $searchParams['publication_from']);
            })
            ->when($searchParams['publication_until'], function ($query) use ($searchParams) {
                return $query->where('t.created_at', '<=', $searchParams['publication_until']);
            })
            ->join('students as s', 's.id', 't.student_id')
            ->join('program_study as ps', 'ps.id', 's.program_study_id')
            ->join('thesis_topics as tt', 'tt.id', 't.topic_id')
            ->join('thesis_types as tte', 'tte.id', 't.type_id')
            ->selectRaw('t.id as thesis_id, t.student_id, s.last_name, s.first_name, t.title as thesis_title, t.abstract as thesis_abstract, ps.name as program_study_name, tt.topic as thesis_topic, t.created_at as publication, tt.id as topic_id, ps.id as program_study_id, tte.id as thesis_type_id, tte.type as thesis_type')
            ->orderBy('t.id', 'desc')
            ->paginate(5);

        $topics = ThesisTopic::all();

        $prodys = ProgramStudy::all();

        $types = ThesisType::all();

        return view('public_views.home', ['documents' => $documents, 'topics' => $topics, 'prodys' => $prodys, 'types' => $types]);
    }

    public function getSuggestionTitle(Request $request)
    {
        $searchInput = $request->title;

        $titles = Thesis::select('title')
            ->where('title', 'like', '%' . $searchInput . '%')
            ->orderBy('id', 'desc')
            ->limit(7)
            ->get()
            ->unique('title');

        return response()->json($titles);
    }

    public function getSuggestionAuthor(Request $request)
    {
        $searchInput = $request->name;

        if ($searchInput == "") return response()->json();


        $names = Student::select('first_name', 'last_name')->where(function ($query) use ($searchInput) {
            $query->where('first_name', 'like', $searchInput . '%')
                ->orWhere('last_name', 'like', $searchInput . '%');
        })->get();

        return response()->json($names);
    }

    public function getSuggestionAuthorByUsername(Request $request)
    {
        $searchInput = $request->username;

        $titles = Student::select('username')->where('username', 'like', '%' . $searchInput . '%')->get();

        return response()->json($titles);
    }

    public function yearFilterView(): View
    {
        $year = $this->thesisService->getYearFilters();

        return view('public_views.publication_year_filter', ["years" => $year]);
    }

    public function studyProgramFilterView(): View
    {
        $programs = $this->thesisService->getProgramStudyFilters();

        return view('public_views.program_study_filter', ["programs" => $programs]);
    }

    public function topicFilterView(): View
    {
        $topics = $this->thesisService->getTopicFilters();

        return view('public_views.topic_filter', ["topics" => $topics]);
    }

    public function authorFilterView(Request $request): View
    {
        $authors = $this->thesisService->getAuthorFilters($request->alphabet);

        return view('public_views.author_filter', ['authors' => $authors]);
    }

    public function thesisTypeFilterView(): View
    {
        $types = $this->thesisService->getThesisTypeFilters();

        return view('public_views.thesis_type_filter', ['types' => $types]);
    }
}
