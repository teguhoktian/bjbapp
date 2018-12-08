<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    //
    protected $fillable = [
    	'code',
    	'name',
    	'parent',
        'corporate_id'
    ];

    /**
    * Get the users for the office.
    */
    public function users()
    {
    	return $this->hasMany('App\User');
    }

    /**
     * Set the office's code.
     *
     * @param  string  $value
     * @return void
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    /**
     * Set the office's parent.
     *
     * @return void
     */
    public function parent()
    {
        return $this->belongsTo('App\Office', 'parent');
    }

    /**
     * Set the office's child.
     *
     * @return void
     */
    public function children()
    {
        return $this->hasMany('App\Office', 'parent');
    }

    /**
     * Set the ocorporate.
     *
     * @return void
     */
    public function corporate()
    {
        return $this->belongsTo('App\Corporate');
    }
}
