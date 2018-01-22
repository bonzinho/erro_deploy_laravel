<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('init');


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('login', 'AdminAuth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'AdminAuth\LoginController@login');
    Route::post('auth/logout', 'AdminAuth\LoginController@logout')->name('logout');

    Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'AdminAuth\RegisterController@register');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});


Route::group(['prefix' => 'collaborator', 'as' => 'collaborator.'], function () {
  Route::get('/login', 'CollaboratorAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'CollaboratorAuth\LoginController@login');
  Route::post('auth/logout', 'CollaboratorAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'CollaboratorAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'CollaboratorAuth\RegisterController@register');

  Route::post('/password/email', 'CollaboratorAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'CollaboratorAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'CollaboratorAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'CollaboratorAuth\ResetPasswordController@showResetForm');
});


Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
  Route::get('/login', 'ClientAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'ClientAuth\LoginController@login');
  Route::post('auth/logout', 'ClientAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'ClientAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'ClientAuth\RegisterController@register');

  Route::post('/password/email', 'ClientAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'ClientAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'ClientAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'ClientAuth\ResetPasswordController@showResetForm');

  Route::get('/home', function(){
      return view('client.home');
  })->name('home');

  Route::get('/thank-u', function (){
        return view('client.thank-u');
  })->name('thank-u');
});


Route::group(['prefix' => 'event', 'as' => 'event.'], function(){

    Route::get('create/withoutlogin', function(){
        $naturezas = new \App\Entities\Nature();
        $naturezas = $naturezas->all();

        $apoios = new \App\Entities\Support();
        $apoios = $apoios->all();

        $espacos = new \App\Entities\Space();
        $espacos = $espacos->all();

        $materiais = new \App\Entities\Material();
        $materiais = $materiais->all();

        $graphics = new \App\Entities\Graphic();
        $graphics = $graphics->all();

        $audiovisuals = new \App\Entities\Audiovisual();
        $audiovisuals = $audiovisuals->all();
        return view('client.event.index', compact('naturezas', 'apoios', 'espacos', 'materiais', 'graphics', 'audiovisuals'));
    })->name('create.withoutlogin');

    Route::put('store/{type}/{login}', 'EventsController@store')
        ->where('type','(admin|client)', 'login', '(login|register)')
        ->name('store');

    Route::get('balance_notify/{token}', 'BalanceNotificationsController@verify')->name('verify-token');
});



