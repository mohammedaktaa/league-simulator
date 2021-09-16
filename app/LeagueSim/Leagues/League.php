<?php


namespace App\LeagueSim\Leagues;


use App\Repositories\LeagueRepositoryInterface;
use App\Repositories\MatchRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Support\Collection;

abstract class League
{
    protected MatchRepositoryInterface $matchRepository;
    protected LeagueRepositoryInterface $leagueRepository;
    protected TeamRepositoryInterface $teamRepository;
    protected string $description;
    protected Collection $schedule;
    protected $id;
    protected array $predictions;


    public abstract function calculatePredictions();

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

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return Collection
     */
    public function getSchedule(): Collection
    {
        return $this->schedule;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getPredictions(): array
    {
        return $this->predictions;
    }
}
