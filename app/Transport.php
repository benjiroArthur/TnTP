<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    //fillables
    protected $fillable = ['email', 'vehicle_number', 'vehicle_brand', 'colour', 'last_name', 'first_name', 'other_name', 'image', 'phone_number'];

    protected $guarded = [];
    protected $appends = ['registered', 'updated'];

    //relationship

   /* public function address(){
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
