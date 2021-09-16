<?php


namespace App\LeagueSim\Matches;


use App\LeagueSim\Teams\Team;

abstract class Match
{
    protected string $description;
    protected Team $hostTeam, $guestTeam;
    protected int $hostTeamScore, $guestTeamScore, $hostTeamPoints, $guestTeamPoints;
    protected $hostLuckFactor, $guestLuckFactor;
    protected $id, $played;

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
        $this->updateState();
    }

    protected function updateState()
    {

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
    public function getHostTeamScore(): int
    {
        return $this->hostTeamScore;
    }

    /**
     * @return int
     */
    public function getGuestTeamScore(): int
    {
        return $this->guestTeamScore;
    }

    /**
     * @return int
     */
    public function getHostTeamPoints(): int
    {
        return $this->hostTeamPoints;
    }

    /**
     * @return int
     */
    public function getGuestTeamPoints(): int
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
