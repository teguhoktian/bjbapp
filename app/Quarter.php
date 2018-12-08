<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quarter extends Model
{
    //

    protected $fillable = [
    	'year',
    	'number',
    	'name',
    	'start_date',
    	'end_date'
    ];

    public function quarter_goal()
    {
    	return $this->hasMany('App\Quarter_goal');
    }
}
