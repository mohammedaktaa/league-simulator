<?php


namespace App\LeagueSim\Leagues;


use Illuminate\Support\Collection;

class ChampionsLeague extends League
{
    public function __construct(string $description, Collection $schedule)
    {
        $this->description = $description;
        $this->schedule = $schedule;
    }

}
