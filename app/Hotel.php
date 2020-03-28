<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    //fillables
    protected $fillable = ['code', 'name', 'email', 'image', 'phone_number'];

    //return with
    protected $with = ['address', 'map'];

    //relationship
    public function address()
    {
        return $this->morphOne('App\Address', 'addressable');
    }
    public function map()
    {
        return $this->morphOne('App\Map', 'mappable');
    }
    public function rooms()
    {
        return $this->hasMany('App\Room');
    }
    public function bookings()
    {
        return $this->hasManyThrough('App\Booking', 'App\Room');
    }
    public function reviews()
    {
        return $this->morphMany('App\Review', 'reviewable');
    }

    public function getImageAttribute($val){
        return asset('assets/ProfilePictures/'.$val);
    }

    public function user(){
        return $this->morphOne('App\User', 'userable');
    }
}
