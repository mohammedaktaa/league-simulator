<?php

namespace Database\Seeders;

use App\Repositories\LeagueRepositoryInterface;
use Illuminate\Database\Seeder;

class LeagueSeed extends Seeder
{
    protected LeagueRepositoryInterface $leagueRepository;

    public function __construct(LeagueRepositoryInterface $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->leagueRepository->create([
            'ChampionsLeague 1'
        ]);
    }
}
