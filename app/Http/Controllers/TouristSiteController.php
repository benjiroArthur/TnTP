<?php

namespace App\Http\Controllers;

use App\TouristSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class TouristSiteController extends Controller
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
        $touristSite = TouristSite::latest()->get();
        return response()->json($touristSite);
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //validate
        $this->validate($request, [
            'name' => 'required|unique:tourist_sites|string',
            'price' => 'required',
            'long' => 'required',
            'lat' => 'required',
            'region' => 'required',
            'city' => 'required',
            'gp_digital_address' => 'required',
        ]);

        //organise the data
        $siteData = [
            'name' => $request->name,
            'price' => $request->price
        ];

        $addressData = [
            'region' => $request->region,
            'city' => $request->city,
            'gp_digital_address' => $request->gp_digital_address
        ];

        $mapData = [
            'lat' => $request->lat,
            'long' => $request->long
        ];
        $touristSite = new TouristSite();
        $touristSite = $touristSite->create($siteData);

        $touristSite->address()->create($addressData);

        $touristSite->map()->create($mapData);

        return response()->json($touristSite);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function imageUpload(Request $request, $id)
    {
        $touristSite = TouristSite::findOrFail($id);
        $oldImage = $touristSite->image;
        $oldSplit = explode('/', $oldImage);
        $oldSplit = $oldSplit[sizeof($oldSplit) -1];

        if($request->hasfile('image')){
            //validate
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
            $image_path = public_path().'/assets/TouristSitePictures/'.$imageNameToStore;
            //resize image
            Image::make($image_file->getRealPath())->resize(140,128)->save($image_path);

            if(File::exists(public_path('/assets/TouristSitePictures/'.$oldSplit)) && $oldSplit !== 'noimage.jpg'){

                File::delete(public_path('/assets/TouristSitePictures/'.$oldSplit));
            }

            $touristSite->image = $imageNameToStore;
            $touristSite->save();

            return response('Success');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //find single site
        $site = TouristSite::findOrFail($id);
        $site_data = [
            'name' => $site->name,
            'price' => $site->price,
            'lat' => $site->map->lat,
            'long' => $site->map->long,
            'region' => $site->address->region,
            'city' => $site->address->city,
            'gp_digital_address' => $site->address->gp_digital_address
        ];
        $allData = [
            'site' => $site,
            'site_data' =>$site_data
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
        //validate
        $this->validate($request, [
            'name' => 'required|string',
            'price' => 'required',
            'long' => 'required',
            'lat' => 'required',
            'region' => 'required',
            'city' => 'required',
            'gp_digital_address' => 'required',
        ]);

        //organise the data
        $siteData = [
            'name' => $request->name,
            'price' => $request->price
        ];

        $addressData = [
            'region' => $request->region,
            'city' => $request->city,
            'gp_digital_address' => $request->gp_digital_address
        ];

        $mapData = [
            'lat' => $request->lat,
            'long' => $request->long
        ];
        $touristSite = TouristSite::findOrFail($id);
        $touristSite->update($siteData);

        $touristSite->address()->update($addressData);

        $touristSite->map()->update($mapData);

        return response('success');
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
