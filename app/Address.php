<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //fillables
    protected $fillable = ['region', 'city', 'gp_digital_address', 'addressable_id', 'addressable_type'];

    //return with


    //relationship

    public function addressable()
    {
        return $this->morphTo();
    }


    public static function tourists($region, $offset=0, $limit=5){
        return Address::where(['region' => $region, 'addressable_type' => TouristSite::class])
            ->with(['addressable'])
//            ->offset(1)
//            ->limit(1)
            ->get();
    }

}
