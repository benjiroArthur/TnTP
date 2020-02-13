<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    //fillables
    protected $fillable = ['lat', 'long', 'mappable_id', 'mappable_type'];

    //relationship
    public function mappable()
    {
        return $this->morphTo();
    }

}
