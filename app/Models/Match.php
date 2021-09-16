<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    protected $fillable = ['week_id', 'host_team_id', 'guest_team_id', 'description', 'host_team_score',
        'guest_team_score', 'host_team_points', 'guest_team_points', 'played'];

    public function hostTeam()
    {
        return $this->belongsTo('App\Models\Team', 'host_team_id');
    }

    public function guestTeam()
    {
        return $this->belongsTo('App\Models\Team', 'guest_team_id');
    }
}
