<?php


namespace App\Repositories\Eloquent;


use App\Repositories\RepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements RepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function update(Model $model, array $attributes): Model
    {
        $model->update($attributes);
        return $model;
    }

    public function insert(array $values)
    {
        $now = Carbon::now();
        foreach ($values as $value) {
            $value['created_at'] = $value['updated_at'] = $now;
        }
        $this->model->insert($values);
    }
}
