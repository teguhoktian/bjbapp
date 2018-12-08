<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    //
    protected $fillable = ['name'];

    public function goal_details()
    {
    	return $this->hasMany('App\Goal_detail');
    }
}
