<?php


namespace App\Repositories;


use App\LeagueSim\Matches\Match;
use App\Models\League;

interface MatchRepositoryInterface extends RepositoryInterface
{
    public function updateState(Match $match);

    public function getMatchesForLeague(League $league);

}
