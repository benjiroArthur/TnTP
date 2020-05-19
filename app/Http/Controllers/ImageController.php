<?php

namespace App\Http\Controllers;

use App\Room;
use App\TouristSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;


class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('images'))
       {
           $images = $request->file('images');

          if($request->type === 'tourist_site'){
              $site = TouristSite::findOrFail($request->id);
              $num = 1;
              foreach ($images as $image){
                  $extension = $image->getClientOriginalExtension();

                  //Filename to store
                  $imageNameToStore = time().$num.'.'.$extension;

                  //$path = $image->storeAs('public/images/tourist_site', $imageNameToStore);
                 $imagePath = public_path('/storage/images/tourist_site/'.$imageNameToStore);
                $img = Image::make($imagePath)->resize(450,300, function($constraint){
                    $constraint->aspectRatio();
                })->save($imagePath);


                  //resize image
                  $thumbImg = \Image::make($image->getRealPath())->fit(450,300)->encode();
                  $mainImg = \Image::make($image->getRealPath())->resize(1080,null,
                      static function ($constraint){
                          $constraint->aspectRatio();
                          $constraint->upsize();
                      })->encode();
                  \Storage::disk('site-images')->put('thumbnails/'.$imageNameToStore, $thumbImg);
                  \Storage::disk('site-images')->put('original/'.$imageNameToStore, $mainImg);



                $site->images()->create(
                   [
                       'name' => $imageNameToStore
                   ]
                );
                  $num++;

              }
              return response('success');
          }
          elseif ($request->type === 'hotel_room'){
              $room = Room::findOrFail($request->id);
              $num = 1;
              foreach ($images as $image){
                  $extension = $image->getClientOriginalExtension();

                  //Filename to store
                  $imageNameToStore = time().$num.'.'.$extension;

                  //resize image
                  $thumbImg = \Image::make($image->getRealPath())->fit(450,300)->encode();
                  $mainImg = \Image::make($image->getRealPath())->resize(1080,null,
                      static function ($constraint){
                          $constraint->aspectRatio();
                          $constraint->upsize();
                      })->encode();
                  \Storage::disk('room-images')->put('thumbnails/'.$imageNameToStore, $thumbImg);
                  \Storage::disk('room-images')->put('original/'.$imageNameToStore, $mainImg);

                  $room->images()->create(
                      [
                          'name' => $imageNameToStore
                      ]
                  );
                  $num++;

              }
              return response('success');
          }
          else{
              return response('Image Type Not Specified');
          }
       }
        return response('no images');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $image = \App\Image::findOrFail($id);

        if(Storage::disk('public')->exists($image->name_path.'thumbnails/'.$image->name)){
            Storage::disk('public')->delete($image->name_path.'thumbnails/'.$image->name);
        }
        if(Storage::disk('public')->exists($image->name_path.'original/'.$image->name)){
            Storage::disk('public')->delete($image->name_path.'original/'.$image->name);
        }
        $image->delete();
        return response('success');

    }
}
