<?php


namespace App\Repositories\Eloquent;


use App\Models\Week;
use App\Repositories\MatchRepositoryInterface;
use App\Repositories\WeekRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class WeekRepository extends BaseRepository implements WeekRepositoryInterface
{
    protected MatchRepositoryInterface $matchRepository;

    public function __construct(Week $model, MatchRepositoryInterface $matchRepository)
    {
        parent::__construct($model);
        $this->matchRepository = $matchRepository;
    }

    public function saveWeekMatches(Week $week, Collection $matches)
    {
        foreach ($matches as $match) {
            $this->matchRepository->create([
                'week_id' => $week->id,
                'host_team_id' => $match->hostTeam->id,
                'guest_team_id' => $match->guestTeam->id,
                'description' => $match->description,
                'host_team_score' => $match->hostTeamScore,
                'guest_team_score' => $match->guestTeamScore,
                'host_team_points' => $match->hostTeamPoints,
                'guest_team_points' => $match->guestTeamPoints,
                'played' => $match->played,
            ]);
        }
    }

}
