<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing_user extends Model
{
    protected $table = 'listing_users';
    public $timestamps = false;

    public function listing_item_amount(){
        return $this->hasMany('App\Listing_item_amount', 'listing_user_id');
    }

    public function listing(){
        return $this->belongsTo('App\Listing', 'listing_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
