<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class RoomsController extends Controller
{
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
        $oldSplit = explode('/', $oldImage);
        $oldSplit = $oldSplit[count($oldSplit) -1];

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

//      $path = $image_file->storeAs('public/assets/ProfilePictures/', $imageNameToStore);
//
            $image_path = storage_path().'/storage/images/rooms/'.$imageNameToStore;
            //resize image
            Image::make($image_file->getRealPath())->resize(140,128)->save($image_path);

            if(File::exists(storage_path('/storage/images/rooms/'.$oldSplit)) && $oldSplit !== 'noroomimage.jpg'){

                File::delete(storage_path('/storage/images/rooms/'.$oldSplit));
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
