<?php

namespace App\Http\Controllers;

use App\City;
use App\Region;
use Illuminate\Http\Request;

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
        $this->validate($request, [
            'region' => 'required',
            'city' => 'required',
        ]);
        $user = Auth()->user();
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
        ]);
        $data = [
            'region' => $request->region,
            'city' => $request->city,
            'pg_digital_address' => $request->pg_digital_address
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
}
