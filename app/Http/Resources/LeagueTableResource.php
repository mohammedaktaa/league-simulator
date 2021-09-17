<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeagueTableResource extends JsonResource
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
            'team_id' => $this['team_id'],
            'participated' => $this['participated'],
            'name' => $this['name'],
            'played_matches' => (int)$this['played_matches'],
            'points' => $this['points'],
            'winning' => $this['winning'],
            'losing' => $this['losing'],
            'draw' => $this['draw'],
            'goal_difference' => $this['goal_difference'],
        ];
    }
}
