<?php


namespace App\Repositories\Eloquent;


use App\LeagueSim\Matches\ChampionsMatch;
use App\LeagueSim\Teams\ChampionsTeam;
use App\LeagueSim\Weeks\ChampionsWeek;
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
                'description' => $week->getDescription(),
                'number' => $week->getNumber(),
                'played' => $week->getPlayed(),
            ]);

            $this->weekRepository->saveWeekMatches($weekModel, $week->getMatches());
        }
    }

    public function getLeagueSchedule(League $league): Collection
    {
        $league->load('weeks.matches.hostTeam', 'weeks.matches.guestTeam');

        $weeks = new Collection();
        foreach ($league->weeks as $week) {
            $matches = new Collection();
            foreach ($week->matches as $match) {
                $matches->add(
                    new ChampionsMatch(
                        new ChampionsTeam(
                            $match->hostTeam->id,
                            $match->hostTeam->name,
                            $match->hostTeam->cooperation_factor,
                            $match->hostTeam->talents_count,
                        ),
                        new ChampionsTeam(
                            $match->guestTeam->id,
                            $match->guestTeam->name,
                            $match->guestTeam->cooperation_factor,
                            $match->guestTeam->talents_count,
                        ),
                        $match->played,
                        $match->id,
                        $match->description,
                        $match->host_team_score,
                        $match->host_team_points,
                        $match->guest_team_score,
                        $match->guest_team_points
                    )
                );
            }
            $weeks->add(
                new ChampionsWeek(
                    $week->description,
                    $week->number,
                    $matches,
                    $week->played,
                    $week->id
                )
            );
        }

        return $weeks;
    }

    public function updateState(League $league, Collection $schedule)
    {
        foreach ($schedule as $week) {
            $this->weekRepository->updateState($week);
        }
    }

    public function reset(League $league)
    {
        $league->matches()->delete();
        $league->weeks()->delete();
    }

    public function all(): Collection {
        return $this->model->all();
    }
}
