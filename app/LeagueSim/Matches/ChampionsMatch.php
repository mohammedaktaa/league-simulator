<?php


namespace App\LeagueSim\Matches;


use App\LeagueSim\Teams\ChampionsTeam;

class ChampionsMatch extends Match
{
    public function __construct(ChampionsTeam $hostTeam, ChampionsTeam $guestTeam, $played = null, $id = null)
    {
        $this->description = $hostTeam->getName() . ' VS ' . $guestTeam->getName();
        $this->hostTeam = $hostTeam;
        $this->guestTeam = $guestTeam;
        $this->played = $played ?? 0;
        $this->id = $id;
        parent::__construct();
    }

    protected function decideTeamsPoints()
    {
        if ($this->hostTeamScore > $this->guestTeamScore) {
            $this->hostTeamPoints = 3;
            $this->guestTeamPoints = 0;
        } else if ($this->hostTeamScore < $this->guestTeamScore) {
            $this->hostTeamPoints = 0;
            $this->guestTeamPoints = 3;
        } else {
            $this->hostTeamPoints = $this->guestTeamPoints = 1;
        }
    }
}
