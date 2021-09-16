<?php


namespace App\Repositories;


use App\Models\Week;
use Illuminate\Support\Collection;

interface WeekRepositoryInterface extends RepositoryInterface
{
    public function saveWeekMatches(Week $week, Collection $matches);
}
