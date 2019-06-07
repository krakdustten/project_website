<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $table = 'listings';
    public $timestamps = false;

    public function listing_teams(){
        return $this->hasMany('App\Listing_team', 'listing_id');
    }

    public function listing_users(){
        return $this->hasMany('App\Listing_user', 'listing_id');
    }
}
