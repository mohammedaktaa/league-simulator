<?php


namespace App\LeagueSim\Fixtures;


use App\LeagueSim\Matches\ChampionsMatch;
use App\LeagueSim\Weeks\ChampionsWeek;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Support\Collection;

class ChampionsFixtureManager extends FixtureManager
{
    protected TeamRepositoryInterface $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->weeks = new Collection();
    }

    public function generateFixture()
    {
        $teams = $this->teamRepository->all();

        $round = $this->matchTeams($teams);

        foreach ($round as $index => $week) {
            $matches = [];
            foreach ($week as $match) {
                $matches[] = new ChampionsMatch($match['home'], $match['away']);
            }
            $this->weeks->add(new ChampionsWeek('Week ' . ($index + 1), $index + 1, collect($matches)));
        }

        foreach ($round as $week) {
            $matches = [];
            foreach ($week as $match) {
                $matches[] = new ChampionsMatch($match['away'], $match['home']);
            }
            $this->weeks->add(new ChampionsWeek('Week ' . (count($round) + 1), count($round) + 1, collect($matches)));
        }
    }

    protected function matchTeams(Collection $teams)
    {
        $teams = $teams->toArray();
        $away = array_splice($teams, (count($teams) / 2));
        $home = $teams;
        $round = [];
        for ($i = 0; $i < count($home) + count($away) - 1; $i++) {
            for ($j = 0; $j < count($home); $j++) {
                $round[$i][$j]["Home"] = $home[$j];
                $round[$i][$j]["Away"] = $away[$j];
            }
            if (count($home) + count($away) - 1 > 2) {
                array_unshift($away, array_shift(array_splice($home, 1, 1)));
                array_push($home, array_pop($away));
            }
        }
        return $round;
    }
}
