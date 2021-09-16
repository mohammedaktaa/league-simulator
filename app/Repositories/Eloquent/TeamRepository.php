<?php


namespace App\Repositories\Eloquent;


use App\Models\Team;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }

    public function all(): Collection
    {
        return $this->model->all(); // todo wrap the models in ChampionsTeam object
    }
}
