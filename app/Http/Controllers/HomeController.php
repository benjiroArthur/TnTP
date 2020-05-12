<?php

namespace App\Http\Controllers;

use App\TouristSite;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function checkUpdate()
    {
        $data = Auth()->user()->profile_updated;
        return response($data);
    }

    public function getSites(){
        $region = Auth()->user()->address->region;
        $sites = TouristSite::all();

        $nearby = TouristSite::whereHas('address', function ($query) use($region){
            $query->where('region', $region);
        })->get();
        $data = [
            'region' => $region,
            'sites' => $sites,
            'nearby' => $nearby
        ];
        return response()->json($data);
    }
}
