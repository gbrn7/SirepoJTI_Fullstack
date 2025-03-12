<?php

namespace App\Providers;

use App\Repositories\ProgramStudyRepository;
use App\Repositories\ThesisRepository;
use App\Services\ProgramStudyService;
use App\Services\ThesisService;
use App\Support\Interfaces\Repositories\ProgramStudyRepositoryInterface;
use App\Support\Interfaces\Repositories\ThesisRepositoryInterface;
use App\Support\Interfaces\Services\ProgramStudyServiceInterface;
use App\Support\Interfaces\Services\ThesisServiceInterface;
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

        $this->app->bind(ProgramStudyRepositoryInterface::class, ProgramStudyRepository::class);
        $this->app->bind(ProgramStudyServiceInterface::class, ProgramStudyService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
