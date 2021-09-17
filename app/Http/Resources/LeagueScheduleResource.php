<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeagueScheduleResource extends JsonResource
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
            'number' => $this->getNumber(),
            'played' => $this->getPlayed(),
            'matches' => LeagueMatchesResource::collection($this->getMatches())
        ];
    }
}
