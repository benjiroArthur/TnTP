<?php

namespace App\Http\Controllers;

use App\City;
use App\Region;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function getProfile(){
        $user = Auth()->user();
        return response()->json($user);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateProfile(Request $request)
    {
        $user = Auth()->user();
        $user->profile_updated = 1;
        $user->save();
        $user->userable()->update($request->all());
        return response('success');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function address(Request $request){

        $this->validate($request, [
            'region' => 'required',
            'city' => 'required',
            'gp_digital_address' => 'required',
        ]);


        $data = [
            'region' => $request->region,
            'city' => $request->city,
            'gp_digital_address' => $request->gp_digital_address
        ];

        $user = Auth()->user();

        if($user->address === null){
            $user->address()->create($data);
            return response('success');
        }
        else{
            $user->address()->update($data);
            return response('success');
        }
    }

    public function region()
    {
        $region = Region::all();
        return response()->json($region);
    }

    public function city($region)
    {
        $region = Region::where('name', $region)->first();
        $region_id = $region->id;

        $city = City::where('region_id', $region_id)->get();

        return response()->json($city);
    }

    public function uploadImage(Request $request){
        $user = Auth()->user()->userable;

        $oldImage = $user->image;
        $oldSplit = explode('/', $oldImage);
        $oldSplit = $oldSplit[sizeof($oldSplit) -1];


        if($request->hasfile('image')){

            try {
                $this->validate($request, [
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
                ]);
            } catch (ValidationException $e) {
                return response($e);
            }

            $image_file = $request->file('image');

            $imageNameWithExt = $image_file->getClientOriginalName();
            //Get just extension
            $extension = $image_file->getClientOriginalExtension();

            //Filename to store
            $imageNameToStore = time().'.'.$extension;

            //upload file

//      $path = $image_file->storeAs('public/assets/ProfilePictures/', $imageNameToStore);
//
            $image_path = public_path().'/assets/ProfilePictures/'.$imageNameToStore;
            //resize image
            Image::make($image_file->getRealPath())->fit(350,350)->save($image_path);

            if(File::exists(public_path('/assets/ProfilePictures/'.$oldSplit)) && $oldSplit !== 'noimage.jpg'){
                File::delete(public_path('/assets/ProfilePictures/'.$oldSplit));
            }

            $user->image = $imageNameToStore;
            $user->save();

            return response('Success');
        }
        else
        {
            return response('No file selected');
        }
    }

    public function passwordUpdate(Request $request, $id){
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);

        if(Hash::check($request->old_password, $user->password)){
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return response('success');
        }
        else{ return response('Invalid Password');}
    }

    public function hotelMap(Request $request){
       $this->validate($request, [
            'lat' => 'required',
            'long' => 'required'
        ]);
        if(auth()->user()->role->name == 'hotel'){
            $hotel = auth()->user()->userable;
            $getMap = $hotel->map()->get();
            if($getMap->isEmpty()){
                $map = $hotel->map()->create($request->all());
            }
            else{
                $hotel->map()->update($request->all());
                $map = $hotel->map()->first();
            }
            return response()->json($map);
        }
    }
}
