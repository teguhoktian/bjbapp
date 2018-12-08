<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking_kredit_goal extends Model
{
    //

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function userGoal()
    {
    	return $this->belongsTo('App\User_goal');
    }
}
