<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //fillables
    protected $fillable = ['user_id', 'reviewable_id', 'reviewable_type', 'rating', 'like'];

    //relationship
    public function reviewable()
    {
      return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
