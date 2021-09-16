<?php


namespace App\Repositories;


interface RepositoryInterface
{
    public function create(array $attributes);

    public function find($id);
}
