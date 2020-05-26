<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'role_id', 'userable_id', 'userable_type', 'profile_updated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['role', 'userable', 'address'];

    //relationship
    public function userable()
    {
        return $this->morphTo();
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function address()
    {
        return $this->morphOne('App\Address', 'addressable');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function trips()
    {
        return $this->hasMany('App\Trip');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }
}
