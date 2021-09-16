<?php


namespace App\LeagueSim\Weeks;


use Illuminate\Support\Collection;

class ChampionsWeek extends Week
{
    public function __construct(string $description, int $number, Collection $matches, $played = null, $id = null)
    {
        $this->description = $description;
        $this->number = $number;
        $this->played = $played ?? 0;
        $this->matches = $matches;
        $this->id = $id;
    }
}
