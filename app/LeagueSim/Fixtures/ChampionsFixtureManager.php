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
                $matches[] = new ChampionsMatch($match['host'], $match['guest']);
            }
            $this->weeks->add(new ChampionsWeek('Week ' . ($index + 1), $index + 1, collect($matches)));
        }

        foreach ($round as $index => $week) {
            $matches = [];
            foreach ($week as $match) {
                $matches[] = new ChampionsMatch($match['guest'], $match['host']);
            }
            $this->weeks->add(new ChampionsWeek(
                    'Week ' . (count($round) + $index + 1),
                    count($round) + $index + 1,
                    collect($matches)
                )
            );
        }
    }

    protected function matchTeams(Collection $teams)
    {
        $teams = $teams->toArray();
        $guests = array_splice($teams, (count($teams) / 2));
        $hosts = $teams;
        $round = [];
        for ($i = 0; $i < count($hosts) + count($guests) - 1; $i++) {
            for ($j = 0; $j < count($hosts); $j++) {
                $round[$i][$j]["host"] = $hosts[$j];
                $round[$i][$j]["guest"] = $guests[$j];
            }
            if (count($hosts) + count($guests) - 1 > 2) {
                $subArr = array_splice($hosts, 1, 1);
                array_unshift($guests, array_shift($subArr));
                array_push($hosts, array_pop($guests));
            }
        }

        return $round;
    }
}
