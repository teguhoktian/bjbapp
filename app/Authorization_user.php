<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authorization_user extends Model
{
    //
    protected $fillable = [
    	'user_id',
    	'approval_first_id',
    	'approval_second_id',
    ];

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
    public function firstAuth()
    {
        return $this->belongsTo('App\User', 'approval_first_id', 'id');
    }

    public function secondAuth()
    {
        return $this->belongsTo('App\User', 'approval_second_id', 'id');
    }

}
