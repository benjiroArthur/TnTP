<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    //fillables
    protected $fillable = ['name', 'tourist_site_id', 'user_id', 'start_date', 'end_date'];

    protected $with = ['touristSite', 'checklist', 'activities'];
    //relationship
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function touristSite()
    {
        return $this->belongsTo('App\TouristSite', 'tourist_site_id');
    }

    public function checklist(){
        return $this->hasMany(CheckList::class,'trip_id');
    }

    public function activities(){
        return $this->hasMany(Activitiy::class,'trip_id');
    }

}
