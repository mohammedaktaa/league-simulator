<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    use HasFactory;

    protected $fillable = ['league_id', 'description', 'number', 'played'];

    public function matches()
    {
        return $this->hasMany('App\Models\Match');
    }
}
