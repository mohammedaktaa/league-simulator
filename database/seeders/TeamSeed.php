<?php

namespace Database\Seeders;

use App\Repositories\TeamRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TeamSeed extends Seeder
{
    protected TeamRepositoryInterface $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            [
                'id' => 1,
                'name' => 'Manchester United',
                'cooperation_factor' => 6,
                'talents_count' => 4,
            ],
            [
                'id' => 2,
                'name' => 'Manchester City',
                'cooperation_factor' => 7,
                'talents_count' => 5,
            ],
            [
                'id' => 3,
                'name' => 'Liverpool',
                'cooperation_factor' => 5,
                'talents_count' => 3,
            ],
            [
                'id' => 4,
                'name' => 'Arsenal',
                'cooperation_factor' => 8,
                'talents_count' => 2,
            ],
            [
                'id' => 5,
                'name' => 'Real Madrid',
                'cooperation_factor' => 5,
                'talents_count' => 6,
            ],
            [
                'id' => 6,
                'name' => 'Barcelona',
                'cooperation_factor' => 8,
                'talents_count' => 6,
            ],
        ];

        $this->teamRepository->insert($teams);
    }
}
