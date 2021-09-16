<?php


namespace App\LeagueSim\Leagues;


use Illuminate\Support\Collection;

abstract class League
{
    protected string $description;
    protected Collection $schedule;


    public function playWeek()
    {
        $currentWeek = $this->schedule->filter(function ($week) {
            return $week->played === 1;
        })->sortBy('number')->last();

        $currentWeek->run();
    }

    public function playAll()
    {
        foreach ($this->schedule as $week) {
            $week->run();
        }
    }
}
