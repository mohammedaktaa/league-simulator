<?php


namespace App\LeagueSim\Leagues;


use Illuminate\Support\Collection;

class ChampionsLeague extends League
{

    public function __construct(string $description, Collection $schedule, $id = null)
    {
        $this->description = $description;
        $this->schedule = $schedule;
        $this->id = $id;
        $this->leagueRepository = app('\App\Repositories\Eloquent\LeagueRepository');
        $this->matchRepository = app('\App\Repositories\Eloquent\MatchRepository');
        $this->teamRepository = app('\App\Repositories\Eloquent\TeamRepository');
    }

    public function calculatePredictions()
    {
        $league = $this->leagueRepository->find($this->getId());
        $matches = $this->matchRepository->getMatchesForLeague($league);
        $firstWeekMatches = $matches->filter(function ($match) {
            return $match->week_number = 1;
        });
        $teamsIds = array_merge(
            $firstWeekMatches->pluck('host_team_id')->toArray(),
            $firstWeekMatches->pluck('guest_team_id')->toArray()
        );

        $oddsArray = [];

        foreach ($teamsIds as $teamId) {
            $team = $this->teamRepository->find($teamId);
            $matchesAsHost = $matches->filter(function ($match) use ($teamId) {
                return $match->host_team_id === $teamId;
            });
            $matchesAsGuest = $matches->filter(function ($match) use ($teamId) {
                return $match->guest_team_id === $teamId;
            });

            $teamPoints = $matchesAsHost->sum('host_team_points') + $matchesAsGuest->sum('guest_team_points');

            $teamGoalsFor = $matchesAsHost->sum('host_team_score') + $matchesAsGuest->sum('guest_team_score');
            $teamGoalsAgainst = $matchesAsHost->sum('guest_team_score') + $matchesAsGuest->sum('host_team_score');
            $teamGoalDifference = $teamGoalsFor - $teamGoalsAgainst;

            $oddsArray[$teamId] = [
                'team' => $team->name,
                'odds' => 10 * $teamPoints + $teamGoalDifference
            ];
        }
        $totalOdds = array_reduce(array_map(function ($item) {
            return $item['odds'];
        }, $oddsArray), function ($carry, $item) {
            $carry += $item;
            return $carry;
        });
        $oddsArray = array_map(function ($item) use ($totalOdds) {
            $item['prediction'] = $totalOdds ? round($item['odds'] / $totalOdds * 100, 2) : 0;
            return $item;
        }, $oddsArray);

        $this->predictions = $oddsArray;
    }

}
