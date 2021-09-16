<?php


namespace App\Repositories;


use App\Models\League;
use Illuminate\Support\Collection;

interface LeagueRepositoryInterface extends RepositoryInterface
{
    public function saveLeagueSchedule(League $league, Collection $schedule);

    public function getLeagueSchedule(League $league): Collection;

    public function updateState(League $league, Collection $schedule);

}
