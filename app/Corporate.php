<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corporate extends Model
{
    //
    protected $fillable = [
    	'corporate_ID',
    	'corporate_name'
    ];

    /**
    * Get the users for the office.
    */
    public function offices()
    {
    	return $this->hasMany('App\Corporate');
    }


    public function user()
    {
        return $this->hasManyThrough('App\User', 'App\Office');
    }

    /**
     * Set the Corporate ID.
     *
     * @param  string  $value
     * @return void
     */
    public function setCorporateIdAttribute($value)
    {
        $this->attributes['corporate_ID'] = strtoupper($value);
    }
}
