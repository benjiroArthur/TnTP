<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    //fillables
    protected $fillable = ['code', 'name', 'email', 'image', 'phone_number'];

    //return with
    protected $with = ['map'];

    protected $appends = ['registered', 'updated', 'full_name', 'first_name'];

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

    public function getRegisteredAttribute(){
        return Carbon::parse($this->created_at)->isoFormat('Do MMMM, YYYY');
    }

    public function getUpdatedAttribute(){
        return Carbon::parse($this->updated_at)->isoFormat('Do MMMM, YYYY');
    }
    public function getFullNameAttribute(){
        return $this->name;
    }

    public function getFirstNameAttribute(){
        $phName = $this->name;
        $phName = explode(" ", $phName);
        $phName = $phName[0];
        return $phName;
    }
}
