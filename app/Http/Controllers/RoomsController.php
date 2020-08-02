<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class RoomsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role->name == 'hotel'){
            $hotel = auth()->user()->userable;
            $rooms = $hotel->rooms;
            return response()->json($rooms);
        }
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
     *
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'room_number' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        $data = $request->all();
        $data['hotel_id'] = auth()->user()->userable->id;
        $room = new Room();
        $newroom = $room->create($data);
        return response()->json($newroom);
    }

    public function imageUpload(Request $request, $id){
        $room = Room::findOrFail($id);
       $oldImage = $room->image;
       /* $oldSplit = explode('/', $oldImage);
        $oldSplit = $oldSplit[count($oldSplit) -1];*/

        if($request->hasFile('image')){
            //validate
                $this->validate($request, [
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
                ]);


            $image_file = $request->file('image');

            $imageNameWithExt = $image_file->getClientOriginalName();
            //Get just extension
            $extension = $image_file->getClientOriginalExtension();

            //Filename to store
            $imageNameToStore = time().'.'.$extension;

            //upload file

            //resize image
            $thumbImg = \Image::make($image_file->getRealPath())->fit(400,300)->encode();
            $mainImg = \Image::make($image_file->getRealPath())->resize(1080,null,
            function ($constraint){
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode();
            \Storage::disk('room-picture')->put('thumbnails/'.$imageNameToStore, $thumbImg);
            \Storage::disk('room-picture')->put('original/'.$imageNameToStore, $mainImg);

            if(\Storage::disk('room-picture')->exists('thumbnails/'.$oldImage)){
                \Storage::disk('room-picture')->delete('thumbnails/'.$oldImage);
            }
             if(\Storage::disk('room-picture')->exists('original/'.$oldImage)){
                \Storage::disk('room-picture')->delete('original/'.$oldImage);
            }


            $room->image = $imageNameToStore;
            $room->save();

            return response('Success');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $room = Room::findOrFail($id);
        $room_data = [
            'room_number' => $room->room_number,
            'price' => $room->price,
            'description' => $room->description,
            'status' => $room->status,
        ];
        $allData = [
            'room' => $room,
            'room_data' =>$room_data
        ];
        return response()->json($allData);
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
        //
    }
}
