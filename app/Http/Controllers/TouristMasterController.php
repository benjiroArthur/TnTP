<?php

namespace App\Http\Controllers;

use App\Address;
use App\Region;
use App\TouristSite;
use Illuminate\Http\Request;

class TouristMasterController extends Controller
{
    public function master(Request $request)
    {
        $mode = $request->mode;

        switch ($mode){
            case "load-tourist-sites":
                return $this->loadTouristSites($request);
                break;
            case "load-by-region":
//                return "here";
                return $this->loadTouristSiteByRegion($request);
                break;
            case "load-regions":
                return $this->loadRegions();
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
        return Region::all();
    }
}
