<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //fillables
    protected $fillable = [
        'name', 'imageable_id', 'imageable_type'
    ];

    //relationship
    public function imageable()
    {
        return $this->morphTo();
    }
}
