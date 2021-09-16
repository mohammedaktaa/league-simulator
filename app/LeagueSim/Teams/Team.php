<?php


namespace App\LeagueSim\Teams;


abstract class Team
{
    protected string $name;
    protected int $id, $cooperationFactor, $talentCount;

    public function calculateStrength()
    {
        return $this->cooperationFactor * 1000 + $this->talentCount * 100;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
