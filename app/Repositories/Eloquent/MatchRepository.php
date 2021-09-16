<?php


namespace App\Repositories\Eloquent;


use App\Models\League;
use App\Models\Match;
use App\Repositories\MatchRepositoryInterface;

class MatchRepository extends BaseRepository implements MatchRepositoryInterface
{
    public function __construct(Match $model)
    {
        parent::__construct($model);
    }

    public function updateState(\App\LeagueSim\Matches\Match $match)
    {
        $model = $this->find($match->getId());

        $this->update($model, [
            'host_team_score' => $match->getHostTeamScore(),
            'guest_team_score' => $match->getGuestTeamScore(),
            'host_team_points' => $match->getHostTeamPoints(),
            'guest_team_points' => $match->getGuestTeamPoints(),
            'played' => $match->getPlayed()
        ]);
    }

    public function getMatchesForLeague(League $league)
    {
        return $this->model
            ->join('weeks', 'weeks.id', '=', 'matches.week_id')
            ->select('matches.*', 'weeks.number AS week_number')
            ->where('weeks.league_id', $league->id)
            ->where('matches.played', 1)
            ->get();
    }


}
