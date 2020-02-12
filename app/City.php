<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //fillables
    protected $fillable = ['region_id', 'name'];

    //relationship
    public function region()
    {
        return $this->belongsTo('App/Region');
    }
}
