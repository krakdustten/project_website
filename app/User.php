<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    public $timestamps = false;

    public function listing_users(){
        return $this->hasMany('App\Listing_user', 'user_id');
    }
}
