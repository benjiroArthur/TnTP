<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'other_name', 'dob', 'gender', 'phone_number', 'image', 'email', 'full_name'
    ];

    protected $guarded = [];
    protected $appends = ['registered', 'updated'];

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
