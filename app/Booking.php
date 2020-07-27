<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpseclib\Crypt\Random;

class Booking extends Model
{



    //fillables
    protected $fillable = ['room_id', 'start_date', 'end_date', 'user_id', 'booking_id'];

    //return with

    protected $with =['user'];

    protected $casts = [
      'start_date'=>'date',
      'end_date'=>'date'
    ];

    //relationship
    public function hotel()
    {
        return $this->room->hotel();
    }
    public function room()
    {
        return $this->belongsTo('App\Room');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
