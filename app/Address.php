<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //fillables
    protected $fillable = ['region_id', 'city_id', 'pg_digital_address', 'addressable_id', 'addressable_type'];

    //return with
    protected $with = ['region', 'city'];

    //relationship
    public function region()
    {
        return $this->belongsTo('App/Region');
    }
    public function city()
    {
        return $this->belongsTo('App/City');
    }

    public function addressable()
    {
        return $this->morphTo();
    }


}
