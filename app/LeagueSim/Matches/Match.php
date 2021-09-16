<?php


namespace App\LeagueSim\Matches;


use App\LeagueSim\Teams\Team;

abstract class Match
{
    protected string $description;
    protected Team $hostTeam, $guestTeam;
    protected int $played, $hostTeamScore, $guestTeamScore, $hostTeamPoints, $guestTeamPoints;
    protected $hostLuckFactor, $guestLuckFactor;

    public function __construct()
    {
        $this->hostLuckFactor = (float)rand() / (float)getrandmax();
        $this->guestLuckFactor = 1 - $this->hostLuckFactor;
    }

    public function play()
    {
        $maxGoals = 10;
        $hostStrength = $this->hostTeam->calculateStrength();
        $guestStrength = $this->guestTeam->calculateStrength();

        $hostWinProbability = ($hostStrength / ($hostStrength + $guestStrength)) * $this->hostLuckFactor;
        $guestWinProbability = ($guestStrength / ($hostStrength + $guestStrength)) * $this->guestLuckFactor;

        $this->hostTeamScore = round($hostWinProbability * $maxGoals);
        $this->guestTeamScore = round($guestWinProbability * $maxGoals);

        $this->played = 1;
        $this->decideTeamsPoints();
    }

    protected abstract function decideTeamsPoints();
}
