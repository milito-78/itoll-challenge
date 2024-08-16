<?php

namespace App\Providers;

use App\Repositories\AccessTokenRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\Interfaces\AccessTokenRepositoryInterface;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\TransporterRepositoryInterface;
use App\Repositories\TransporterRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRepositories();

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }


    private function registerRepositories(): void
    {
        $this->app->singleton(AccessTokenRepositoryInterface::class,AccessTokenRepository::class);
        $this->app->singleton(CompanyRepositoryInterface::class,CompanyRepository::class);
        $this->app->singleton(TransporterRepositoryInterface::class,TransporterRepository::class);
    }
}
