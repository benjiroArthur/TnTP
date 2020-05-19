<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //fillables
    protected $fillable = ['hotel_id', 'room_number', 'price', 'description', 'status', 'image'];

    //with
    protected $with =['bookings', 'images'];
    protected $appends = ['thumbnail', 'source'];

    //relationship
    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }
    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function getThumbnailAttribute(){
        return asset('storage/images/hotel_room/thumbnails/'.$this->image);
    }
    public function getSourceAttribute(){
        return asset('storage/images/hotel_room/original/'.$this->image);
    }
}
