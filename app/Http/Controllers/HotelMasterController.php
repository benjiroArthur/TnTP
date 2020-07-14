<?php

namespace App\Http\Controllers;

use App\Address;
use App\Hotel;
use App\NearSite;
use App\Room;
use App\TouristSite;
use Illuminate\Http\Request;

class HotelMasterController extends Controller
{
    public function master(Request $request)
    {
        $mode = $request->mode;

        switch ($mode) {
            case "load-nearby-sites":
                return $this->loadNearbySites($request);
                break;
            case "load-region-sites":
                return $this->loadRegionTouristSites($request);
                break;
            case "remove-from-near-site":
                return $this->removeFromNearSites($request);
                break;
            case "add-to-near-site":
                return $this->addToNearSite($request);
                break;
            case "load-hotel":
                return $this->loadHotel($request);
                break;
            case "load-room":
                return $this->loadRoom($request);
                break;
            case "load-hotel-rooms":
                return $this->loadHotelRooms($request);
                break;
            case "load-nearby-hotels":
                return $this->loadNearbyHotel($request);
                break;
            default :
//                abort("504","haha got you.");
        }
    }

    private function loadNearbySites(Request $request)
    {
        //   return return \auth()->user()->address->region;
        $hotelId = auth()->user()->userable->id;
        return Hotel::find($hotelId)->nearSites->load('tsite');
//        return new NearSiteCollection(Hotel::find($hotelId)->nearSites);

    }

    private function loadRegionTouristSites(Request $request)
    {
//        return Region::find(auth()->user()->userable_id)->tourists();
//        $region = $request->region;

        return Address::tourists(\auth()->user()->address->region);
    }


    private function addToNearSite(Request $request)
    {
        $touristSite = TouristSite::find($request->site_id);
        $nearSite = new NearSite();
        $hotelId = auth()->user()->userable->id;
        $nearSite->hotel_id = $hotelId;
        $nearSite->tourist_site_id = $touristSite->id;

        $count = NearSite::where([
            ['hotel_id', $hotelId],
            ['tourist_site_id', $touristSite->id]
        ])->count();

        if ($count < 1) {
            Hotel::find($hotelId)->nearSites()->save($nearSite);
        }

        return Hotel::find($hotelId)->nearSites->load('tsite');
    }

    private function removeFromNearSites(Request $request)
    {
        $touristSite = TouristSite::find($request->site_id);

        $hotelId = auth()->user()->userable->id;
        $nearSite = NearSite::where([
            ['hotel_id', $hotelId],
            ['tourist_site_id', $touristSite->id]
        ])->delete();
//        Hotel::find($hotelId)->nearSites()->detach($touristSite);
        return Hotel::find($hotelId)->nearSites->load('tsite');
    }

    private function loadNearbyHotel(Request $request)
    {
        $touristSite = TouristSite::find($request->site_id);
        return $touristSite->nearbyhotels->load('hotel');
//        return $touristSite->nearbyHotels()->without('tsite')->get();
    }

    private function loadHotel(Request $request)
    {
        return Hotel::find($request->hotel_id);
    }

    private function loadRoom(Request $request)
    {
        return Room::find($request->room_id);
    }

    private function loadHotelRooms(Request $request)
    {
        $hotel = Hotel::find($request->hotel_id);
        return $hotel->rooms;

    }
}
