<?php


namespace App\Repositories\Eloquent;


use App\Models\Week;
use App\Repositories\MatchRepositoryInterface;
use App\Repositories\WeekRepositoryInterface;
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
                'host_team_id' => $match->getHostTeam()->getId(),
                'guest_team_id' => $match->getGuestTeam()->getId(),
                'description' => $match->getDescription(),
                'host_team_score' => $match->getHostTeamScore(),
                'guest_team_score' => $match->getGuestTeamScore(),
                'host_team_points' => $match->getHostTeamPoints(),
                'guest_team_points' => $match->getGuestTeamPoints(),
                'played' => $match->getPlayed(),
            ]);
        }
    }

    public function updateState(\App\LeagueSim\Weeks\Week $week)
    {
        $model = $this->find($week->getId());

        $this->update($model, [
            'played' => $week->getPlayed()
        ]);
        foreach ($week->getMatches() as $match) {
            $this->matchRepository->updateState($match);
        }
    }

}
