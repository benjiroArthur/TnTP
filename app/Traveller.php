<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traveller extends Model
{
    //fillable
    protected $fillable = ['last_name', 'first_name', 'other_name', 'email', 'dob', 'gender', 'phone_number', 'image'];

    protected $guarded = [];

    public function getFullNameAttribute(){
        if($this->other_name === null){
            return ucfirst($this->first_name).' '.ucfirst($this->last_name);
        }
        return ucfirst($this->first_name).' '.ucfirst($this->other_name).' '.ucfirst($this->last_name);
    }

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
