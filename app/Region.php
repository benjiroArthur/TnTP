<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Str;

class Region extends Model
{
    //fillables
    protected $fillable = ['name'];

    protected $appends = [
        'url_name'
    ];

    //relationship
    public function city()
    {
        return $this->hasMany('App\City');
    }

    public function tourists()
    {
        return $this->hasMany(TouristSite::class);
    }

    public function getUrlNameAttribute()
    {
        return Str::slug($this->name);
    }

}
