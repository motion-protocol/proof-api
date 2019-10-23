<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ProofRegistry\Domain\Movie\MovieRepository;
use ProofRegistry\Domain\RightsHolder\RightsHolderRepository;
use ProofRegistry\Infrastructure\ApplicationServiceLifeCycle;
use ProofRegistry\Infrastructure\Repositories\MysqlMovieRepository;
use ProofRegistry\Infrastructure\Repositories\MysqlRightsHolderRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MovieRepository::class, MysqlMovieRepository::class);
        $this->app->bind(RightsHolderRepository::class, MysqlRightsHolderRepository::class);
        $this->app->bind(\ProofRegistry\Application\ApplicationServiceLifeCycle::class, ApplicationServiceLifeCycle::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
