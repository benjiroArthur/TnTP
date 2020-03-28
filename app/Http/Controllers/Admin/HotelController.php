<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewUser;
use App\Hotel;
use App\HotelCode;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all Hotels
        $role = Role::where('name', 'hotel')->first();
        //get all admins
        $hotels = User::where('role_id', $role->id)->get();
        return response()->json($hotels);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        $this->validate($request, [
            'name' => 'string|required|max:255',
            'email' => 'email|required|max:255|unique:admins|unique:users',
            'password' => 'required|min:8'
        ]);

        $code = "";
        $hcedes = HotelCode::latest()->first();
        if($hcedes == null)
        {
            $val = 1;
            $rec = new HotelCode();
            $rec->code = $val;
            $rec->save();


        }
        else
        {
            $val = $hcedes->code + 1;
            $rec = new HotelCode();
            $rec->code = $val;
            $rec->save();

        }
        if($val < 10)
        {
            $code = "TIG-H-000".$val;
        }
        elseif($val > 9 && $val < 100){
            $code = "TIG-H-00".$val;
        }
        elseif($val > 99 && $val < 1000){
            $code = "TIG-H-0".$val;
        }
        elseif($val > 900){
            $code = "TIG-H-".$val;
        }
        $hotel = new Hotel();


        $newHotel = $hotel->create([
            'name' => $request->name,
            'email' => $request->email,
            'code' => $code
        ]);

        $role = Role::where('name', 'hotel')->first();

        $user = $newHotel->user()->create([
            'email' => $request->email,
            'password'=> Hash::make($request->password),
            'role_id'=> $role->id
        ]);
        broadcast(new NewUser($user));
        return response('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
