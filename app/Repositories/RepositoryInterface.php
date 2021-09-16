<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function create(array $attributes);

    public function find($id);

    public function update(Model $model, array $attributes);

    public function insert(array $values);
}
