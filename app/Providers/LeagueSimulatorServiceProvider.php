<?php

namespace App\Providers;

use App\LeagueSim\Fixtures\ChampionsFixtureManager;
use App\LeagueSim\Fixtures\FixtureManager;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\LeagueRepository;
use App\Repositories\Eloquent\MatchRepository;
use App\Repositories\Eloquent\TeamRepository;
use App\Repositories\Eloquent\WeekRepository;
use App\Repositories\LeagueRepositoryInterface;
use App\Repositories\MatchRepositoryInterface;
use App\Repositories\RepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use App\Repositories\WeekRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class LeagueSimulatorServiceProvider extends ServiceProvider
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
        $this->app->bind(WeekRepositoryInterface::class, WeekRepository::class);
        $this->app->bind(FixtureManager::class, ChampionsFixtureManager::class);
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
