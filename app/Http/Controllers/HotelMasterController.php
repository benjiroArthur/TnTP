<?php

namespace App\Http\Controllers;

use App\Address;
use App\Booking;
use App\Events\NewUser;
use App\Events\RoomBooked;
use App\Hotel;
use App\NearSite;
use App\Room;
use App\TouristSite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Random;


class HotelMasterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
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
            case "load-booking":
                return $this->myBookings($request);
                break;
            case "find-booking-by-code":
                return $this->findBookByCode($request);
                break;
            default :
                abort("404");
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
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $room_id = $request->room_id;
        $user_id = auth()->id();



        $booking = new Booking();
        $booking->booking_code = 454445;
        $booking->start_date = $start_date;
        $booking->end_date = $end_date;
        $booking->room_id = $room_id;
        $booking->user_id = $user_id;

        $room = Room::findOrFail($room_id);
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

        $book = Array();
        $book['booking'] = $booking;
        $book['user_id'] = $booking->hotel()->user()->id;

//        Send Broadcast to Hotel
        broadcast(new RoomBooked($book));

//        broadcast(new NewUser(auth()->user()));
        return [
            'booking_code'=>$booking->booking_code,

        ];
    }

    private function cancelBookedRoom(Request $request)
    {

    }

    private function findBookByCode(Request $request){
        $code = $request->code;
//        return $code;

//        $book = Booking::where('booking_code',$code)->first()->withoutRelations();
        $book = Booking::where('booking_code','TIG-H-001100-0697')->first()->withoutRelations();

        $room = Room::find($book->room_id)->withoutRelations();

        return [
            'code'=>$code,
            'book'=>$book,
            'room'=>$room,
            'hotel'=>$room->hotel
        ];

            // activeBook:{
            //     code:'',
            //     startDate:'',
            //     endDate:'',
            //     room:{
            //         roomId:2,
            //         roomNumber:"",
            //     }
            // },
    }

    private function myBookings(Request $request){
        return auth()->user()->bookings;
    }

    private function checkBookedRoom(Request $request)
    {
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $room_id = $request->room_id;

        $room = Room::findOrFail($room_id);
        $roomBookings = $room->bookings;

        foreach ($start_date->toPeriod($end_date,1,'day') as $time) {
            foreach ($roomBookings as $roomBook) {
                if($time->betweenIncluded($roomBook->start_date,$roomBook->end_date)){
                    return [
                        'available'=>false,
                    ];
                }
            }
        }

        return [
          'available'=>true,
        ];
    }
}
