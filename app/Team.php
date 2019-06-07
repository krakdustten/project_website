<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';
    public $timestamps = false;

    public function listing_teams(){
        return $this->hasMany('App\Listing_team', 'team_id');
    }
}
