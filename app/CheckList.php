<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{
    //relationship
    public function trip(){
        return $this->belongsTo('App\Tip');
    }
}
