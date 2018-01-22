<?php

namespace App\Http\Controllers\CollaboratorAuth;

use App\Entities\Collaborator;
use App\Events\AfterCollaboratorSignInEvent;
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
    protected $redirectTo = '/collaborator/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('collaborator.guest');
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
            'email' => 'required|email|max:255|unique:collaborators',
            'password' => 'required|min:6|confirmed',
            'genre' => 'required',
            'phone' =>  'required',
            'type' =>  'required',
            'address' => 'max:255',
            'postal_code' => 'max:10',
            'locality' => 'max:255',
            'cc' =>  'required',
            'nif' =>  'required',
            'iban' =>  'required',
            'photo' => 'required',
            'cv' =>  'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Collaborator
     */
    protected function create(array $data)
    {
        //verificar se existe photo e preparar a mesmo para o evento
        if(isset($data['photo'])){
            $photo = $data['photo'];
            $data['photo'] = env('photo_perfil_default');
        }else{
            $photo = new \Illuminate\Http\UploadedFile(
                storage_path('app/files/collaborator/perfil_photo/photo_perfil_default.jpg'), 'photo_perfil_default.jpg');
            $data['photo'] = env('photo_perfil_default');
        }


        //verificar se existe photo e preparar a mesmo para o evento
        if(isset($data['cv'])){
            $cv = $data['cv'];
            $data['cv'] = env('cv_default');
        }

        $collaborator = \App\Entities\Collaborator::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'genre' => $data['genre'],
            'phone' => $data['phone'],
            'type' => $data['type'],
            'address' => $data['address'],
            'postal_code' => $data['postal_code'],
            'locality' => $data['locality'],
            'cc' => $data['cc'],
            'nif' => $data['nif'],
            'iban' => $data['iban'],
            'photo' => $data['photo'],
            'cv' => $data['cv'],
        ]);
        $event = new AfterCollaboratorSignInEvent($photo, $cv, $collaborator);
        event($event);
        return $collaborator;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('collaborator.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('collaborator');
    }
}
