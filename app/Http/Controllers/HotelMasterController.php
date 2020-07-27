<?php

namespace App\Http\Controllers;

use App\Address;
use App\Booking;
use App\Events\RoomBooked;
use App\Hotel;
use App\NearSite;
use App\Room;
use App\TouristSite;
use Illuminate\Http\Request;
use Random;


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
            case "book-room":
                return $this->bookRoom($request);
                break;
            case "cancel-booked-room":
                return $this->cancelBookedRoom($request);
                break;
            case "check-booked-room":
                return $this->checkBookedRoom($request);
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

    private function loadNearbyHotel(Request $request)
    {
        $touristSite = TouristSite::find($request->site_id);
        return $touristSite->nearbyhotels->load('hotel');
//        return $touristSite->nearbyHotels()->without('tsite')->get();
    }

    private function bookRoom(Request $request)
    {
//        return $request;
//        fasxx
//        return [
//            $request->end_date,
//            $request->start_date
//        ];


        $booking = new Booking();
        $booking->booking_code = 454445;
        $booking->start_date = $request->start_date;
        $booking->end_date = $request->end_date;
        $booking->room_id = $request->room_id;
        $booking->user_id = auth()->id();

        $room = Room::findOrFail($request->room_id);
        $hotel_code = $room->hotel->code;

        while (true) {
//            $prefix = Random::generateString(2, '56789');
            $prefix = $hotel_code;
            $append = Random::generateString(4, '1234567890');

            $code = $prefix . "-" . $append;
            if (Booking::where('booking_code', $code)->count() == 0) {
                break;
            }
        }
        $booking->booking_code = $code;

        $booking->save();

//        Send Broadcast to Hotel
        broadcast(new RoomBooked($booking));

        return $booking;
    }

    private function cancelBookedRoom(Request $request)
    {

    }

    private function checkBookedRoom(Request $request)
    {

    }
}
