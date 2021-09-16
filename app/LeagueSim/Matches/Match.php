<?php


namespace App\LeagueSim\Matches;


use App\LeagueSim\Teams\Team;

abstract class Match
{
    protected string $description;
    protected Team $hostTeam, $guestTeam;
    protected $id, $played, $hostTeamScore, $guestTeamScore, $hostTeamPoints, $guestTeamPoints;
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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPlayed()
    {
        return $this->played;
    }

    /**
     * @return int
     */
    public function getHostTeamScore()
    {
        return $this->hostTeamScore;
    }

    /**
     * @return int
     */
    public function getGuestTeamScore()
    {
        return $this->guestTeamScore;
    }

    /**
     * @return int
     */
    public function getHostTeamPoints()
    {
        return $this->hostTeamPoints;
    }

    /**
     * @return int
     */
    public function getGuestTeamPoints()
    {
        return $this->guestTeamPoints;
    }

    /**
     * @return Team
     */
    public function getHostTeam(): Team
    {
        return $this->hostTeam;
    }

    /**
     * @return Team
     */
    public function getGuestTeam(): Team
    {
        return $this->guestTeam;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

}
