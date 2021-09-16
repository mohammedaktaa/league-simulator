<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeagueRequest;
use App\LeagueSim\Fixtures\ChampionsFixtureManager;
use App\LeagueSim\Leagues\ChampionsLeague;
use App\Models\League;
use App\Repositories\LeagueRepositoryInterface;
use Illuminate\Http\Request;

class LeaguesController extends Controller
{
    protected LeagueRepositoryInterface $leagueRepository;
    protected ChampionsFixtureManager $fixtureManager;

    public function __construct(LeagueRepositoryInterface $leagueRepository, ChampionsFixtureManager $fixtureManager)
    {
        $this->leagueRepository = $leagueRepository;
        $this->fixtureManager = $fixtureManager;
    }

    public function store(StoreLeagueRequest $request)
    {
        $league = $this->leagueRepository->create($request->validated());
        $this->fixtureManager->generateFixture();
        $this->leagueRepository->saveLeagueSchedule($league, $this->fixtureManager->getFixture());
        return response()->json([
            'message' => 'League Created Successfully',
        ], 200);
    }

    public function show(League $league)
    {
        $leagueObj = new ChampionsLeague(
            $league->description,
            $this->leagueRepository->getLeagueSchedule($league),
            $league->id
        );
        return response()->json([
            'data' => [
                'description' => $leagueObj->getDescription(),
                'schedule' => $leagueObj->getSchedule(),
                'predictions' => $leagueObj->calculatePredictions()
            ]
        ], 200);
    }

    public function playWeek(League $league)
    {
        $leagueSchedule = $this->leagueRepository->getLeagueSchedule($league);
        $leagueObj = new ChampionsLeague($league->description, $leagueSchedule);

        $leagueObj->playWeek();

        $this->leagueRepository->updateState($league, $leagueSchedule);
        return response()->json([
            'data' => $this->leagueRepository->getLeagueSchedule($league)
        ], 200);
    }

    public function playAll(League $league)
    {
        $leagueSchedule = $this->leagueRepository->getLeagueSchedule($league);
        $leagueObj = new ChampionsLeague($league->description, $leagueSchedule);

        $leagueObj->playAll();

        $this->leagueRepository->updateState($league, $leagueSchedule);
        return response()->json([
            'data' => $this->leagueRepository->getLeagueSchedule($league)
        ], 200);
    }
}
