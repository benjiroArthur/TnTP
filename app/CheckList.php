<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{
    protected $fillable = ['name'];

    //relationship
    public function trip(){
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
