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


}
