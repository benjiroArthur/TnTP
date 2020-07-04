<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //fillables
    protected $fillable = [
        'name', 'imageable_id', 'imageable_type', 'description'
    ];
    protected $appends = ['thumbnail', 'source'];
    //relationship
    public function imageable()
    {
        return $this->morphTo();
    }

    public function getNamePathAttribute(){
        if($this->imageable_type === 'App\TouristSite'){
            return 'images/tourist_site/';
        }
        return 'images/hotel_rooms/';
    }

    public function getThumbnailAttribute(){
        if($this->imageable_type === 'App\TouristSite'){
            return asset('storage/images/tourist_site/thumbnails/'.$this->name);
        }
        elseif($this->imageable_type === 'App\Hotel'){
            return asset('storage/images/hotel/thumbnails/'.$this->name);
        }
        return asset('storage/images/hotel_rooms/thumbnails/'.$this->name);
    }
    public function getSourceAttribute(){
        if($this->imageable_type === 'App\TouristSite'){
            return asset('storage/images/tourist_site/original/'.$this->name);
        }
        elseif ($this->imageable_type === 'App\Hotel'){
            return asset('storage/images/hotel/original/'.$this->name);
        }
        return asset('storage/images/hotel_rooms/original/'.$this->name);
    }


}
