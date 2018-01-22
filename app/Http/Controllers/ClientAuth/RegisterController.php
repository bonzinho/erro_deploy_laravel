<?php

namespace App\Http\Controllers\ClientAuth;

use App\Client;
use App\Events\AddEventAndRegisterAccountEvent;
use App\Repositories\ClientRepository;
use Mockery\Exception;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/client/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('client.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:clients',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return ClientRepository
     */
    protected function create(array $data)
    {
        try{
            $create = \App\Entities\Client::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'address' => $data['address'],
                'postal_code' => $data['postal_code'],
                'locality' => $data['locality'],
                'nif' => $data['nif'],
                'phone' => $data['phone'],
                'type' => $data['type'],
                'ac_name' => $data['ac_name'],
            ]);
            $event = new AddEventAndRegisterAccountEvent($create);
            event($event);
            return $create;
        }catch (Exception $e){
            $data = [
                'message' => $e->getMessage()
            ];
            return $data;
        }

    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('client.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('client');
    }
}
