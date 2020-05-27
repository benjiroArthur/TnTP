<?php


namespace App\Http\Traits;


use Carbon\Carbon;

trait FromNow
{
    public function getFromNowAttribute(){
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getNiceDateAttribute(){
        return Carbon::parse($this->date)->isoFormat('Do MMMM, YYYY');
    }
}
