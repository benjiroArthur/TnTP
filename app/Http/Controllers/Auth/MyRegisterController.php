<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use App\Hotel;
use App\HotelCode;
use App\User;
use App\Transport;
use App\Traveller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class MyRegisterController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

    }

    public function userRegister(Request $request)
    {
        //tourists and drivers records
        if($request->user_type == 'traveller' || $request->user_type == 'transport')
        {
            $this->validate($request, [
                'last_name' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users|unique:travellers|unique:transports',
                'password' => 'required|string|min:8|confirmed'
            ]);
            if($request->user_type == 'traveller')
            {
                $role = Role::where('name', 'traveller')->first();
                $traveller = new Traveller();
                $data = $request->except('password', 'password_confirmation', 'user_type');
                $traveller->create($data);

                //save user instatce
                $newTrav = Traveller::where('email', $request->email)->first();
                $request['password'] = Hash::make($request->password);

                $newTrav->user()->create(['email' => $request->email, 'password'=> $request->password, 'role_id'=>$role->id]);

                //login after successful registration
                if(Auth::attempt(['email' => $request->email, 'password'=> $request->password]))
                {
                    //if successful, then redirect to dashboard
                    return redirect()->intended(url('/home'))->with('success', 'Registration Successful');
                }
                else{
                    return redirect()->back();
                }
            }
            else
             {
                 $transport = new Transport();
                 $data = $request->except('password', 'password_confirmation', 'user_type');
                 $transport->create($data);

                 //save user instance
                 $role = Role::where('name', 'transport')->first();
                 $newTran = Transport::where('email', $request->email)->first();
                 $request['password'] = Hash::make($request->password);
                 $newTran->user()->create(['email' => $request->email, 'password'=> $request->password, 'role_id'=>$role->id]);

                 //login after successful registration
                 if(Auth::attempt(['email' => $request->email, 'password'=> $request->password]))
                 {
                     //if successful, then redirect to dashboard
                     return redirect()->intended(url('/home'))->with('success', 'Registration Successful');

                 }
                 else{
                     return redirect()->back();
                 }
            }

        }
        //hotel records
        elseif ($request->user_type == 'hotel')
        {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed'
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
                $code = "tigH000".$val;
            }
            elseif($val > 9 && $val < 100){
                $code = "tigH00".$val;
            }
            elseif($val > 99 && $val < 1000){
                $code = "tigH0".$val;
            }
            elseif($val > 900){
                $code = "tigH".$val;
            }
        }
        $hotel = new Hotel();
         $data = $request->all();
         $data['password'] = Hash::make($request->password);
         $data['code'] = $code;
         $hotel->create($data);

        $role = Role::where('name', 'hotel')->first();
         $newHotel = Hotel::where('email', $request->email)->first();
         $newHotel->user()->create(['email'=>$request->email, 'password'=>$request->password, 'role_id'=>$role->id]);



        if(Auth::attempt(['email' => $request->email, 'password'=> $request->password]))
        {
            //if successful, then redirect to dashboard
            return redirect()->intended(url('/home'))->with('success', 'Registration Successful');
        }
        else{
            return redirect()->back();
        }

    }
    }
