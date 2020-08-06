<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Str;

class Room extends Model
{
    //fillables
    protected $fillable = ['hotel_id', 'room_number', 'price', 'description', 'status', 'image'];

    //with

    protected $withCount = ['bookings'];

    protected $with =['images'];

    protected $appends = ['thumbnail', 'source','url_name'];


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

    public function getUrlNameAttribute(){
        return Str::slug($this->room_number);
    }

    public function getThumbnailAttribute(){
        return asset('storage/images/hotel_room/thumbnails/'.$this->image);
    }
    public function getSourceAttribute(){
        return asset('storage/images/hotel_room/original/'.$this->image);
    }
}
