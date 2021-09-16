<?php

namespace App\Providers;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\LeagueRepository;
use App\Repositories\Eloquent\MatchRepository;
use App\Repositories\Eloquent\TeamRepository;
use App\Repositories\LeagueRepositoryInterface;
use App\Repositories\MatchRepositoryInterface;
use App\Repositories\RepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, BaseRepository::class);
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
        $this->app->bind(LeagueRepositoryInterface::class, LeagueRepository::class);
        $this->app->bind(MatchRepositoryInterface::class, MatchRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
