<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing_item extends Model
{
    protected $table = 'listing_items';
    public $timestamps = false;

    public function listing_item_amount(){
        return $this->hasMany('App\Listing_item_amount', 'listing_item_id');
    }

    public function vender(){
        return $this->belongsTo('App\Listing_vender', 'vender_id');
    }
}
