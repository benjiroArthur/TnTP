<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    //fillables
    protected $fillable = ['email', 'vehicle_number', 'vehicle_brand', 'colour', 'last_name', 'first_name', 'other_name', 'image'];

    protected $guarded = [];

    //relationship

    public function address(){
        return $this->morphOne('App\Address', 'addressable');
    }
    public function user(){
        return $this->morphOne('App\User', 'userable');
    }

    public function getImageAttribute($val){
        return asset('assets/ProfilePictures/'.$val);
    }
}
