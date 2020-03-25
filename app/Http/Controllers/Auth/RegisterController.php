<?php

namespace App\Http\Controllers\Auth;

use App\Hotel;
use App\HotelCode;
use App\Http\Controllers\Controller;
use App\Role;
use App\Transport;
use App\Traveller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if($data['user_type'] == 'hotel') {
            return Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed'
            ]);
        }
        else{
            return Validator::make($data, [
                'last_name' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users|unique:travellers|unique:transports',
                'password' => 'required|string|min:8|confirmed'
            ]);
        }

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if($data['user_type'] == 'traveller')
        {
            $role = Role::where('name', 'traveller')->first();
            $traveller = new Traveller();

            $traveller->create([
                'last_name' => $data['last_name'],
                'first_name' => $data['first_name'],
                'other_name' => $data['other_name'],
                'email' => $data['email']
            ]);

            //save user instatce
            $newTrav = Traveller::where('email', $data['email'])->first();


           $user = $newTrav->user()->create([
                'email' => $data['email'],
                'password'=> Hash::make($data['password']),
                'role_id'=> $role->id
            ]);
            return $user;
        }
        elseif ($data['user_type'] == 'transport')
        {
            $transport = new Transport();
            $transport->create([
                'last_name' => $data['last_name'],
                'first_name' => $data['first_name'],
                'other_name' => $data['other_name'],
                'email' => $data['email']
            ]);

            //save user instance
            $role = Role::where('name', 'transport')->first();
            $newTran = Transport::where('email', $data['email'])->first();

            $user = $newTran->user()->create([
                'email' => $data['email'],
                'password'=> Hash::make($data['password']),
                'role_id'=> $role->id
            ]);
            return $user;
        }
        else
        {
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
        }
        $hotel = new Hotel();


        $hotel->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'code' => $code
        ]);

        $role = Role::where('name', 'hotel')->first();
        $newHotel = Hotel::where('email', $data['email'])->first();
        $user = $newHotel->user()->create([
            'email' => $data['email'],
            'password'=> Hash::make($data['password']),
            'role_id'=> $role->id
        ]);
        return $user;


    }

}
