<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NearSite extends Model
{


//    protected $with = [
//        'tsite',
//        'hotel'
//    ];
//    tsite = tourist site
    public function tsite()
    {
        return $this->belongsTo(TouristSite::class, 'tourist_site_id');
    }


    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
