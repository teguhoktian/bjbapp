<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'status', 'office_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function office()
    {
        return $this->belongsTo('App\Office');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }


    public function user_goal()
    {
        return $this->hasMany('App\User_goal');
    }

    public function authorization_user()
    {
        return $this->hasOne('App\Authorization_user');
    }

    public function bookingKreditGoal()
    {
        return $this->hasMany('App\Booking_kredit_goal');
    }

    public function appAuth()
    {
        return $this->hasOne('App\Authorization_user', 'user_id', 'id');
    }

}

