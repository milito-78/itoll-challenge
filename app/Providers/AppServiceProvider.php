<?php

namespace App\Providers;

use App\Repositories\AccessTokenRepository;
use App\Repositories\Interfaces\AccessTokenRepositoryInterface;
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
    }
}
