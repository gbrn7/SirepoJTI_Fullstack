<?php

namespace App\Providers;

use App\Repositories\ProgramStudyRepository;
use App\Repositories\StudentRepository;
use App\Repositories\ThesisRepository;
use App\Repositories\ThesisTopicRepository;
use App\Repositories\ThesisTypeRepository;
use App\Services\ProgramStudyService;
use App\Services\StudentService;
use App\Services\ThesisService;
use App\Services\ThesisTopicService;
use App\Services\ThesisTypeService;
use App\Support\Interfaces\Repositories\ProgramStudyRepositoryInterface;
use App\Support\Interfaces\Repositories\StudentRepositoryInterface;
use App\Support\Interfaces\Repositories\ThesisRepositoryInterface;
use App\Support\Interfaces\Repositories\ThesisTopicRepositoryInterface;
use App\Support\Interfaces\Repositories\ThesisTypeRepositoryInterface;
use App\Support\Interfaces\Services\ProgramStudyServiceInterface;
use App\Support\Interfaces\Services\StudentServiceInterface;
use App\Support\Interfaces\Services\ThesisServiceInterface;
use App\Support\Interfaces\Services\ThesisTopicServiceInterface;
use App\Support\Interfaces\Services\ThesisTypeServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ThesisRepositoryInterface::class, ThesisRepository::class);
        $this->app->bind(ThesisServiceInterface::class, ThesisService::class);

        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(StudentServiceInterface::class, StudentService::class);

        $this->app->bind(ProgramStudyRepositoryInterface::class, ProgramStudyRepository::class);
        $this->app->bind(ProgramStudyServiceInterface::class, ProgramStudyService::class);

        $this->app->bind(ThesisTopicRepositoryInterface::class, ThesisTopicRepository::class);
        $this->app->bind(ThesisTopicServiceInterface::class, ThesisTopicService::class);

        $this->app->bind(ProgramStudyRepositoryInterface::class, ProgramStudyRepository::class);
        $this->app->bind(ProgramStudyServiceInterface::class, ProgramStudyService::class);

        $this->app->bind(ThesisTypeRepositoryInterface::class, ThesisTypeRepository::class);
        $this->app->bind(ThesisTypeServiceInterface::class, ThesisTypeService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
