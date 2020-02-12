<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //fillables
    protected $fillable = ['region_id', 'city_id', 'pg_digital_address'];

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
    public function user()
    {
        return $this->belongsTo('App/User');
    }
    public function addressable()
    {
        return $this->morphTo();
    }


}
