<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;

    protected $fillable = ['description'];

    public function weeks()
    {
        return $this->hasMany('App\Models\Week');
    }

    public function matches()
    {
        return $this->hasManyThrough('App\Models\Match', 'App\Models\Week');
    }
}
