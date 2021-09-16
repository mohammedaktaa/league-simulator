<?php


namespace App\LeagueSim\Teams;


class ChampionsTeam extends Team
{
    public function __construct(string $name, int $cooperationFactor, int $talentCount)
    {
        $this->name = $name;
        $this->cooperationFactor = $cooperationFactor;
        $this->talentCount = $talentCount;
    }
}
