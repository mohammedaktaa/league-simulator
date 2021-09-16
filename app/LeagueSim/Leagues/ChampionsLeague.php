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
        $this->leagueRepository = app('\App\Repositories\LeagueRepositoryInterface');
        $this->matchRepository = app('\App\Repositories\MatchRepositoryInterface');
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

        foreach ($teamsIds as $teamsId) {
            $teamMatches = $matches->fitlter(function ($match) use ($teamsId) {
                return $match->host_team_id === $teamsId || $match->guest_team_id === $teamsId;
            });
        }

    }

}
