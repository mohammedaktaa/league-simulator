<?php


namespace App\Repositories\Eloquent;


use App\Models\League;
use App\Models\Week;
use App\Repositories\LeagueRepositoryInterface;
use App\Repositories\WeekRepositoryInterface;
use Illuminate\Support\Collection;

class LeagueRepository extends BaseRepository implements LeagueRepositoryInterface
{
    protected WeekRepositoryInterface $weekRepository;

    public function __construct(League $model, WeekRepositoryInterface $weekRepository)
    {
        parent::__construct($model);
        $this->weekRepository = $weekRepository;
    }

    public function saveLeagueSchedule(League $league, Collection $schedule)
    {
        foreach ($schedule as $week) {
            $weekModel = $this->weekRepository->create([
                'league_id' => $league->id,
                'description' => $week->description,
                'number' => $week->number,
                'played' => $week->played,
            ]);

            $this->weekRepository->saveWeekMatches($weekModel, $week->getMatches());
        }
    }

    public function getLeagueSchedule(League $league)
    {

    }
}
