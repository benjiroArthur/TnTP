<?php

namespace App;

use App\Http\Traits\UrlName;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Hotel extends Model
{
    use UrlName;

    //fillables
    protected $fillable = ['code', 'name', 'email', 'image', 'phone_number'];

    //return with

    protected $with = ['map', 'rooms','images'];

    protected $withCount = ['rooms','bookings'];


    protected $appends = ['registered', 'updated', 'full_name', 'first_name', 'url_name'];

    //relationship
    public function address()
    {
        //return $this->morphOne('App\Address', 'addressable');
        return $this->user()->address;
    }

    public function map()
    {
        return $this->morphOne('App\Map', 'mappable');
    }
    public function rooms()
    {
        return $this->hasMany('App\Room');
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
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

    public function getThumbnailAttribute(){
        return asset('storage/images/hotel/thumbnails/'.$this->image);
    }
    public function getSourceAttribute(){
        return asset('storage/images/hotel/original/'.$this->image);
    }

    public function getLocAttribute(){
        return $this->user->address;
    }

    public function getFirstNameAttribute(){
        $phName = $this->name;
        $phName = explode(" ", $phName);
        $phName = $phName[0];
        return $phName;
    }

    public function nearSites()
    {
        return $this->hasMany(NearSite::class);
    }

    public static function imageLocation(){
        return "hotel-images";
    }

}
