<?php


namespace App\Http\Traits;


use Str;

trait UrlName
{


    public function getUrlNameAttribute(){
        return Str::slug($this->name);
    }

}
