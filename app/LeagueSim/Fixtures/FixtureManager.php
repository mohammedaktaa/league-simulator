<?php


namespace App\LeagueSim\Fixtures;


use Illuminate\Support\Collection;

abstract class FixtureManager
{
    protected Collection $weeks;

    public abstract function generateFixture();

    public function getFixture(): Collection
    {
        return $this->weeks;
    }
}
