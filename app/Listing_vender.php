<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing_vender extends Model
{
    protected $table = 'listing_venders';
    public $timestamps = false;

    public function listing_items(){
        return $this->hasMany('App\Listing_item', 'vender_id');
    }
}
