<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //fillables
    protected $fillable = [
        'name', 'imageable_id', 'imageable_type', 'description'
    ];

    //relationship
    public function imageable()
    {
        return $this->morphTo();
    }

    public function getNamePathAttribute(){
        $val = $this->name;
        $val = explode('/', $val);
        $val = $val[count($val) -1];
        if($this->imageable_type === 'App\TouristSite'){
            return 'images/tourist_site/'.$val;
        }
        return 'images/hotel_rooms/'.$val;
    }
    public function getNameAttribute($val){
        if($this->imageable_type === 'App\TouristSite'){
        return public_path('storage/images/tourist_site/'.$val);
        }
        return public_path('storage/images/hotel_rooms/'.$val);
    }


}
