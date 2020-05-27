<?php

namespace App;

use App\Http\Traits\FromNow;
use Illuminate\Database\Eloquent\Model;

class Activitiy extends Model
{
    use FromNow;
    //

    protected $fillable = [
      'name', 'done', 'date'
    ];

    protected $casts = [
      'done'=>'boolean'
    ];

    protected $appends = [
        'nice_date'
    ];

    //relationship
    public function trip(){
        return $this->belongsTo(Trip::class);
    }



}
