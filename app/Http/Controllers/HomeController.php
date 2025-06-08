<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThesisAuthorResource;
use App\Http\Resources\ThesisTitleResource;
use App\Models\Student;
use App\Support\Enums\SubmissionStatusEnum;
use App\Support\Interfaces\Services\ProgramStudyServiceInterface;
use App\Support\Interfaces\Services\StudentServiceInterface;
use App\Support\Interfaces\Services\ThesisServiceInterface;
use App\Support\Interfaces\Services\ThesisTopicServiceInterface;
use App\Support\Interfaces\Services\ThesisTypeServiceInterface;
use App\Support\model\GetThesisReqModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(
        protected ThesisServiceInterface $thesisService,
        protected  ThesisTopicServiceInterface $thesisTopicService,
        protected  ProgramStudyServiceInterface $programStudyService,
        protected  ThesisTypeServiceInterface $thesisTypeService,
        protected  StudentServiceInterface $studentService,
    ) {}

    public function welcomeView(): View
    {
        return view('public_views.welcome');
    }

    public function homeView(Request $request): View
    {
        $request->merge([
            'submission_status' => SubmissionStatusEnum::ACCEPTED->value,
        ]);
        $reqModel = new GetThesisReqModel($request);

        $documents = $this->thesisService->getThesis($reqModel);

        $topics = $this->thesisTopicService->getThesisTopics();

        $prodys = $this->programStudyService->getProgramStudys();

        $types = $this->thesisTypeService->getThesisTypes();

        return view('public_views.home', ['documents' => $documents, 'topics' => $topics, 'prodys' => $prodys, 'types' => $types]);
    }

    public function getSuggestionThesisTitle(Request $request)
    {
        $searchInput = $request->title;

        $titles = $this->thesisService->getSuggestionThesisTitle($searchInput);

        return ThesisTitleResource::collection($titles);
    }

    public function getSuggestionAuthor(Request $request)
    {
        $searchInput = $request->name;

        if ($searchInput == "") return response()->json();

        $names = $this->studentService->getSuggestionAuthor($searchInput);

        return ThesisAuthorResource::collection($names);
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
        $authors = $this->studentService->getAuthorFilters($request->alphabet);

        return view('public_views.author_filter', ['authors' => $authors]);
    }

    public function thesisTypeFilterView(): View
    {
        $types = $this->thesisService->getThesisTypeFilters();

        return view('public_views.thesis_type_filter', ['types' => $types]);
    }
}
