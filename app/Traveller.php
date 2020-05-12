<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Traveller extends Model
{
    //fillable
    protected $fillable = ['last_name', 'first_name', 'other_name', 'email', 'dob', 'gender', 'phone_number', 'image'];

    protected $guarded = [];
    protected $appends = ['registered', 'updated'];


    /*public function address(){
        return $this->morphOne('App\Address', 'addressable');
    }*/
    public function user(){
        return $this->morphOne('App\User', 'userable');
    }

    public function getImageAttribute($val){
        return asset('assets/ProfilePictures/'.$val);
    }

    public function getRegisteredAttribute(){
        return Carbon::parse($this->created_at)->isoFormat('Do MMMM, YYYY');
    }

    public function getUpdatedAttribute(){
        return Carbon::parse($this->updated_at)->isoFormat('Do MMMM, YYYY');
    }
}
