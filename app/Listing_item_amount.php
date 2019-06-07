<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing_item_amount extends Model
{
    protected $table = 'listing_item_amounts';
    public $timestamps = false;

    public function listing_user(){
        return $this->belongsTo('App\Listing_user', 'listing_user_id');
    }

    public function listing_item(){
        return $this->belongsTo('App\Listing_item', 'listing_item_id');
    }
}
