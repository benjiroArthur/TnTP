<?php

namespace App\Http\Controllers;

use App\Address;
use App\Region;
use App\TouristSite;
use App\Trip;
use Illuminate\Http\Request;

class TouristMasterController extends Controller
{
    public function master(Request $request)
    {
        $mode = $request->mode;

        switch ($mode) {
            case "load-tourist-sites":
                return $this->loadTouristSites($request);
                break;
            case "load-tourist-site":
                return $this->loadTouristSite($request);
                break;
            case "load-by-region":
//                return "here";
                return $this->loadTouristSiteByRegion($request);
                break;
            case "load-regions":
                return $this->loadRegions();
                break;
            case "load-region":
                return $this->loadRegion($request);
                break;
            case "create-trip":
                return $this->createTrip($request);
                break;
        }

    }

    private function loadTouristSites($request)
    {
        $offset = $request->offset;
        $limit = 5;

        return json_encode(TouristSite::offset($offset)->limit($limit)->get());

    }

    private function loadTouristSiteByRegion($request)
    {
//        return "okay";
        $offset = $request->offset;
        $limit = 5;

        $region = Region::find($request->region_id);

        return Address::tourists($region->name, $offset, $limit);
    }

    private function loadRegions()
    {
        return Region::orderBy('name')->get();
    }

    private function loadRegion($request)
    {
        return Region::find($request->region_id);
    }

    private function loadTouristSite( $request)
    {
        return TouristSite::find($request->site_id);
    }

    private function createTrip( $request)
    {
        $trip = new Trip();
        $trip->name = $request->trip_name;
        $trip->start_date = $request->start_date;
        $trip->end_date = $request->end_date;
        $trip->user_id = auth()->id();
        $trip->tourist_site_id = $request->site_id;

        $trip -> save();
        return "good";

    }
}
