<?php


namespace App\Repositories\Eloquent;


use App\LeagueSim\Matches\ChampionsMatch;
use App\LeagueSim\Teams\ChampionsTeam;
use App\LeagueSim\Weeks\ChampionsWeek;
use App\Models\League;
use App\Models\Team;
use App\Models\Week;
use App\Repositories\LeagueRepositoryInterface;
use App\Repositories\WeekRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function getLeagueTable(League $league)
    {
        $common = 'FROM matches
            JOIN weeks on weeks.id = matches.week_id
            JOIN leagues on leagues.id = weeks.league_id
            WHERE leagues.id = ' . $league->id;

        $leagueTable = Team::select('id AS team_id', 'name',
            DB::raw('(SELECT COUNT(*) ' . $common . '
            AND (matches.host_team_id = team_id OR matches.guest_team_id = team_id)) AS participated'),

            DB::raw('(SELECT SUM(matches.played) ' . $common . '
            AND (matches.host_team_id = team_id OR matches.guest_team_id = team_id)) AS played_matches'),

            DB::raw('(SELECT SUM(COALESCE(matches.host_team_points, 0)) '
                . $common . ' AND matches.host_team_id = team_id)
            AS points_as_host'),

            DB::raw('(SELECT SUM(COALESCE(matches.guest_team_points, 0)) '
                . $common . ' AND matches.guest_team_id = team_id)
            AS points_as_guest'),

            DB::raw('(SELECT COUNT(1) ' . $common . '
            AND matches.host_team_id = team_id
            AND matches.host_team_points = 3)
            AS winning_as_host'),

            DB::raw('(SELECT COUNT(1) ' . $common . '
            AND matches.guest_team_id = team_id
            AND matches.guest_team_points = 3)
            AS winning_as_guest'),

            DB::raw('(SELECT COUNT(1) ' . $common . '
            AND matches.played = 1
            AND matches.host_team_id = team_id
            AND matches.host_team_points = 0)
            AS losing_as_host'),

            DB::raw('(SELECT COUNT(1) ' . $common . '
            AND matches.played = 1
            AND matches.guest_team_id = team_id
            AND matches.guest_team_points = 0)
            AS losing_as_guest'),

            DB::raw('(SELECT COUNT(1) ' . $common . '
            AND matches.played = 1
            AND (matches.host_team_id = team_id OR matches.guest_team_id = team_id)
            AND matches.host_team_points = matches.guest_team_points)
            AS draw'),

            DB::raw('(SELECT COALESCE(SUM(matches.host_team_score), 0) ' . $common . '
            AND matches.played = 1
            AND matches.host_team_id = team_id)
            AS goals_for_as_host'),

            DB::raw('(SELECT COALESCE(SUM(matches.guest_team_score), 0) ' . $common . '
            AND matches.played = 1
            AND matches.guest_team_id = team_id)
            AS goals_for_as_guest'),

            DB::raw('(SELECT COALESCE(SUM(matches.guest_team_score), 0) ' . $common . '
            AND matches.played = 1
            AND matches.host_team_id = team_id)
            AS goals_against_as_host'),

            DB::raw('(SELECT COALESCE(SUM(matches.host_team_score), 0) ' . $common . '
            AND matches.played = 1
            AND matches.guest_team_id = team_id)
            AS goals_against_as_guest')
        )
            ->having('participated', '>', 0)
            ->get();

        return $leagueTable->map(function ($team) {
            return [
                'team_id' => $team['team_id'],
                'participated' => $team['participated'],
                'name' => $team['name'],
                'played_matches' => $team['played_matches'],
                'points' => $team['points_as_host'] + $team['points_as_guest'],
                'winning' => $team['winning_as_host'] + $team['winning_as_guest'],
                'losing' => $team['losing_as_host'] + $team['losing_as_guest'],
                'draw' => $team['draw'],
                'goal_difference' => $team['goals_for_as_host'] + $team['goals_for_as_guest']
                    - $team['goals_against_as_host'] - $team['goals_against_as_guest'],
            ];
        });
    }
}
