<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeagueRequest;
use App\Http\Resources\LeaguePredictionsResource;
use App\Http\Resources\LeagueScheduleResource;
use App\Http\Resources\LeaguesResource;
use App\LeagueSim\Fixtures\FixtureManager;
use App\LeagueSim\Leagues\ChampionsLeague;
use App\Models\League;
use App\Repositories\LeagueRepositoryInterface;
use Illuminate\Http\Request;

class LeaguesController extends Controller
{
    protected LeagueRepositoryInterface $leagueRepository;
    protected FixtureManager $fixtureManager;

    public function __construct(LeagueRepositoryInterface $leagueRepository, FixtureManager $fixtureManager)
    {
        $this->leagueRepository = $leagueRepository;
        $this->fixtureManager = $fixtureManager;
    }

    public function index()
    {
        $leagues = $this->leagueRepository->all();
        return response()->json([
            'date' => LeaguesResource::collection($leagues)
        ], 200);
    }

    public function store(StoreLeagueRequest $request)
    {
        $league = $this->leagueRepository->create($request->validated());
        return response()->json([
            'message' => 'League created successfully',
            'date' => LeaguesResource::make($league)
        ], 200);
    }

    public function show(League $league)
    {
        $leagueObj = new ChampionsLeague(
            $league->description,
            $this->leagueRepository->getLeagueSchedule($league),
            $league->id
        );
        $leagueObj->calculatePredictions();
        return response()->json([
            'data' => [
                'league' => LeaguesResource::make($league),
                'league_table' => $this->leagueRepository->getLeagueTable($league),
                'schedule' => LeagueScheduleResource::collection($leagueObj->getSchedule()),
                'predictions' => LeaguePredictionsResource::collection($leagueObj->getPredictions())
            ]
        ], 200);
    }

    public function init(League $league)
    {
        $this->leagueRepository->reset($league);
        $this->generateFixture($league);
        return response()->json();
    }

    public function playWeek(League $league)
    {
        $leagueSchedule = $this->leagueRepository->getLeagueSchedule($league);
        $leagueObj = new ChampionsLeague($league->description, $leagueSchedule);

        $leagueObj->playWeek();

        $this->leagueRepository->updateState($league, $leagueSchedule);
        return response()->json();
    }

    public function playAll(League $league)
    {
        $leagueSchedule = $this->leagueRepository->getLeagueSchedule($league);
        $leagueObj = new ChampionsLeague($league->description, $leagueSchedule);

        $leagueObj->playAll();

        $this->leagueRepository->updateState($league, $leagueSchedule);
        return response()->json();
    }

    protected function generateFixture(League $league)
    {
        $this->fixtureManager->generateFixture();
        $this->leagueRepository->saveLeagueSchedule($league, $this->fixtureManager->getFixture());
    }
}
