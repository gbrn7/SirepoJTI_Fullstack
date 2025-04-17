<?php

namespace App\Http\Controllers;

use App\Support\Interfaces\Services\LecturerServiceInterface;
use App\Support\Interfaces\Services\ProgramStudyServiceInterface;
use App\Support\Interfaces\Services\ThesisServiceInterface;
use App\Support\Interfaces\Services\ThesisTopicServiceInterface;
use App\Support\Interfaces\Services\ThesisTypeServiceInterface;
use App\Support\model\GetThesisReqModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected ThesisServiceInterface $thesisService,
        protected ProgramStudyServiceInterface $prodyService,
        protected  ThesisTopicServiceInterface $thesisTopicService,
        protected  LecturerServiceInterface $lecturerService,
        protected  ThesisTypeServiceInterface $thesisTypeService,
    ) {}

    public function index(Request $request)
    {
        $reqModel = new GetThesisReqModel($request);

        $prodys = $this->prodyService->getProgramStudys();
        $topics = $this->thesisTopicService->getThesisTopics();
        $lecturer = $this->lecturerService->getLecturers(null, false);
        $types = $this->thesisTypeService->getThesisTypes();

        $dashboard = $this->thesisService->getThesisDashboard($reqModel);

        return view('dashboard.index', [
            'prodys' => $prodys,
            'topics' => $topics,
            'lecturers' => $lecturer,
            'types' => $types,
            'thesisTotalCount' => $dashboard['thesisTotalCount'],
            'thesisTotalMaleFemale' => $dashboard['thesisTotalMaleFemale'],
            'thesisPerYearChart' => $dashboard['thesisTotalPerYearBarChart'],
            'thesisTotalPerTopic' => $dashboard['thesisTotalPerTopic'],
            'thesisTotalPerLecturer' => $dashboard['thesisTotalPerLecturer'],
            'thesisTotalPerPrody' => $dashboard['thesisTotalPerPrody'],
            'thesisTotalPerType' => $dashboard['thesisTotalPerType'],
            'thesisTotalPerClassYear' => $dashboard['thesisTotalPerClassYear'],
            'thesisTotalPerPublicationYear' => $dashboard['thesisTotalPerPublicationYear'],
        ]);
    }
}
