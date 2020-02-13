<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TouristSite extends Model
{
    //fillables
    protected $fillable = ['name', 'image', 'price'];

    public function map()
    {
        return $this->morphOne('App\Map', 'mappable');
    }
    public function reviews()
    {
        return $this->morphMany('App\Review', 'reviewable');
    }
    public function address()
    {
        return $this->morphOne('App\Address', 'addressable');
    }
     public function trips()
        {
            return $this->hasMany('App\Trips');
        }

}
