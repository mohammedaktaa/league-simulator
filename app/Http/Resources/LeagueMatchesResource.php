<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeagueMatchesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getId(),
            'description' => $this->getDescription(),
            'played' => $this->getPlayed(),
            'host_team_score' => $this->getHostTeamScore(),
            'guest_team_score' => $this->getGuestTeamScore(),
            'host_team_points' => $this->getHostTeamPoints(),
            'guest_team_points' => $this->getGuestTeamPoints(),
        ];
    }
}
