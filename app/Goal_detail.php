<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal_detail extends Model
{
    //
    protected $fillabel = [
    	'name', 'goal_id'
    ];

    public function goal()
    {
    	return $this->belongsTo('App\Goal');
    }

    public function goal_detail()
    {
    	return $this->belongsTo('App\Goal_detail');
    }    	
}
