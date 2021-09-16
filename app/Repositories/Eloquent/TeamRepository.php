<?php


namespace App\Repositories\Eloquent;


use App\LeagueSim\Teams\ChampionsTeam;
use App\Models\Team;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Support\Collection;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }

    public function all(): Collection
    {
        $teamsModels = $this->model->all();
        $teams = new Collection();
        foreach ($teamsModels as $team) {
            $teams->add(new ChampionsTeam(
                    $team->id,
                    $team->name,
                    $team->cooperation_factor,
                    $team->talents_count
                )
            );
        }
        return $teams;
    }
}
