<?php


namespace App\LeagueSim\Weeks;


use App\LeagueSim\Matches\Match;
use Illuminate\Support\Collection;

abstract class Week
{
    protected string $description;
    protected int $number, $played;
    protected Collection $matches;

    public function run()
    {
        foreach ($this->matches as $match) {
            $match->play();
        }

        $this->played = 1;
    }

    public function getMatches()
    {
        return $this->matches;
    }
}
