<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //fillables
    protected $fillable = ['hotel_id', 'room_number', 'price', 'description', 'status', 'image'];

    //with
    protected $with =['bookings', 'images', 'hotel'];

    //relationship
    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function getImageAttribute($val){
        return public_path('storage/images/rooms/'.$val);
    }
}
