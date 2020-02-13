<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //fillables
    protected $fillable = ['hotel_id', 'room_number', 'price', 'description', 'status', 'image'];

    //relationship
    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }
    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }
}
