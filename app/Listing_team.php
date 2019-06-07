<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing_team extends Model
{
    protected $table = 'listing_teams';
    public $timestamps = false;

    public function listing(){
        return $this->belongsTo('App\Listing', 'listing_id');
    }

    public function team(){
        return $this->belongsTo('App\Team', 'team_id');
    }
}
