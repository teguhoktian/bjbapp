<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quarter_goal extends Model
{
    //

    protected $fillable = [
    	'quarter_id',
    	'goal_detail_id',
    	'amount',
    	'breakdown',
    	'orientation'
    ];


    public function quarter()
    {
    	return $this->belongsTo('App\Quarter');
    }


    public function goal_detail()
    {
    	return $this->belongsTo('App\Goal_detail');
    }

    public function user_goal()
    {
        return $this->hasMany('App\Goal_user');
    }
}
