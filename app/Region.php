<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //fillables
    protected $fillable = ['name'];

    //relationship
    public function city()
    {
        return $this->hasMany('App\City');
    }
    public function address()
    {
        return $this->belongsToMany('App\Address');
    }
}
