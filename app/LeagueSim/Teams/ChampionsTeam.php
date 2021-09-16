<?php


namespace App\LeagueSim\Teams;


class ChampionsTeam extends Team
{
    public function __construct(int $id, string $name, int $cooperationFactor, int $talentCount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cooperationFactor = $cooperationFactor;
        $this->talentCount = $talentCount;
    }
}
