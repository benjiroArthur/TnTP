<?php

namespace App;

use App\Http\Traits\FromNow;
use App\Http\Traits\UrlName;
use Arr;
use Illuminate\Database\Eloquent\Model;

class TouristSite extends Model
{
    use UrlName, FromNow;
    //fillables
    protected $fillable = ['name', 'image', 'price'];

    protected $with = ['map', 'reviews', 'address', 'images'];

    protected $withCount = ['reviews'];

    protected $appends = [
        'thumbnail',
        'source',
        'url_name',
        'awesome_date'

//        'is_it_near'
    ];


    public function map()
    {
        return $this->morphOne('App\Map', 'mappable');
    }
    public function reviews()
    {
        return $this->morphMany('App\Review', 'reviewable');
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
    public function address()
    {
        return $this->morphOne('App\Address', 'addressable');
    }
     public function trips()
    {
        return $this->hasMany('App\Trips');
    }

    public function nearbyHotels()
    {
        return $this->hasMany(NearSite::class,'tourist_site_id');
    }



//    public function getIsItNearAttribute(){
//        return $this->reg;
//    }

    public function getThumbnailAttribute(){
        return asset('storage/images/TouristSitePictures/thumbnails/'.$this->image);
    }
    public function getSourceAttribute(){
        return asset('storage/images/TouristSitePictures/original/'.$this->image);
    }

}
