<?php

namespace App\Http\Controllers;

use App\Activitiy;
use App\Address;
use App\CheckList;
use App\Region;
use App\TouristSite;
use App\Trip;
use App\User;
use Illuminate\Http\Request;
use Torann\GeoIP\GeoIP;

class TouristMasterController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function master(Request $request)
    {
        $mode = $request->mode;

        switch ($mode) {
            case "load-tourist-sites":
                return $this->loadTouristSites($request);
                break;
            case "search-tourist-sites-by-name":
                return $this->searchTouristSiteByName($request);
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
            case "load-trips":
                return $this->loadTrips();
                break;
            case "load-region":
                return $this->loadRegion($request);
                break;
            case "create-trip":
                return $this->createTrip($request);
                break;
            case "add-item-to-list":
                return $this->addItemToList($request);
                break;
            case "add-activity-to-list":
                return $this->addActivityToList($request);
                break;
            case "toggle-activity-done-state":
                return $this->toggleActivityDoneState($request);
                break;
            case "remove-item-from-list":
                return $this->removeItemFromList($request);
                break;
            case "remove-activity-from-list":
                return $this->removeActivityFromList($request);
                break;
        }

        return abort(404);
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

    private function searchTouristSiteByName($request)
    {
        $name = $request->site_name;
        $offset = $request->q_offset;


        return json_encode(TouristSite::where('name', 'like', "%$name%")->get());
    }

    private function loadRegions()
    {

        return Region::orderBy('name')->get();
    }

    private function loadRegion($request)
    {

        return Region::find($request->region_id);
    }

    private function loadTrips()
    {
        return response(User::find(auth()->id())->trips);
    }

    private function addItemToList($request)
    {
        $tripId = $request->trip_id;
        $name = $request->check_name;
        $trip = Trip::findOrFail($tripId);
        $checkList = new CheckList(['name' => $name]);
        $trip->checklist()->save($checkList);
        return Trip::find($tripId)->checklist;

    }

    private function addActivityToList($request)
    {
        $tripId = $request->trip_id;
        $name = $request->name;
        $trip = Trip::findOrFail($tripId);
        $activity = new Activitiy(['name' => $name, 'done' => false, 'date' => $request->date]);
        $trip->activities()->save($activity);
        return Trip::find($tripId)->activities;

    }

    private function loadTouristSite($request)
    {
        return TouristSite::find($request->site_id);
    }

    private function createTrip($request)
    {
        $trip = new Trip();
        $trip->name = $request->trip_name;
        $trip->start_date = $request->start_date;
        $trip->end_date = $request->end_date;
        $trip->user_id = auth()->id();
        $trip->tourist_site_id = $request->site_id;

        $trip->save();
        return "good";

    }

    private function removeItemFromList($request)
    {
        $checklist = CheckList::find($request->item_id);
        $tripId = $checklist->trip->id;
        try {
            $checklist->delete();
        } catch (\Exception $e) {
            abort(404);
        }
        return Trip::find($tripId)->checklist;
    }

    private function removeActivityFromList($request)
    {
        $activity = Activitiy::find($request->id);
        $tripId = $activity->trip->id;
        try {
            $activity->delete();
        } catch (\Exception $e) {
            abort(404);
        }
        return Trip::find($tripId)->activities;
    }

    private function toggleActivityDoneState($request)
    {
        $activity = Activitiy::find($request->id);
        $tripId = $activity->trip->id;
        $activity->done ? $activity->done = false : $activity->done = true;
        $activity->save();
        return Trip::find($tripId)->activities;
    }
}
