<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //fillables
    protected $fillable = ['name'];

    //relationship
    public function user()
    {
        return $this->hasMany('App\User');
    }
}
