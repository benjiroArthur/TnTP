<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\Room;
use App\TouristSite;
use Illuminate\Http\Request;

class HomeMasterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request)
    {
        $mode = $request->mode;
        switch ($mode) {
            case "load-stats":
                return $this->loadStats($request);
                break;
            case "load-random-hotels":
                return $this->loadRandomHotels($request);
                break;
        }

    }

    //
    private function loadStats(Request $request)
    {
        $hotels = Hotel::all()->count();
        $tsites = TouristSite::all()->count();
        $rooms = Room::all()->count();
        return [
            'hotels' => $hotels,
            'tsites' => $tsites,
            'rooms' => $rooms,
        ];
    }

    private function loadRandomHotels(Request $request)
    {
        return Hotel::inRandomOrder()->limit(15)->get();
//        return $hotels;
    }
}
