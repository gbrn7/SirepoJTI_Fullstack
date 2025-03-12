<?php

namespace App\Providers;

use App\Repositories\ThesisRepository;
use App\Services\ThesisService;
use App\Support\Interfaces\Repositories\ThesisRepositoryInterface;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
