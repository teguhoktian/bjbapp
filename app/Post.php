<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //

    protected $dates = [
    	'created_date',
    	'updated_data'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
