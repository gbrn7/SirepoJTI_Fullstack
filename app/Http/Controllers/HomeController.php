<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudy;
use App\Models\Student;
use App\Models\Thesis;
use App\Models\ThesisTopic;
use App\Models\ThesisType;
use App\Support\Interfaces\Services\ThesisServiceInterface;
use App\Support\model\GetThesisReqModel;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
        $reqModel = new GetThesisReqModel($request);

        $documents = $this->thesisService->getThesis($reqModel);

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
