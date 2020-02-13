<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    //fillables
    protected $fillable = ['name', 'tourist_site_id', 'user_id', 'start_date', 'end_date'];

    //relationship
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function touristSite()
    {
        return $this->belongsTo('App\TouristSite');
    }


}
