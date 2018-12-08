<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_goal extends Model
{
    //
    protected $fillable = [
    	'user_id',
    	'quarter_goal_id',
    	'amount'
    ];


    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function quarter_goal()
    {
    	return $this->belongsTo('App\Quarter_goal');
    }

    public function bookingKreditGoal()
    {
        return $this->hasMany('App\Booking_kredit_goal');
    }
}
