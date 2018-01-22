<?php

/*Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('client')->user();
    return view('client.home');
})->name('home');*/

Route::get('/home', 'ClientsController@index')->name('home');

Route::get('list/{type}/{client}', 'EventsController@eventList')->name('list');

Route::group(['prefix' => 'events', 'as' => 'events.', 'middleware' => ['auth:client']], function(){

    Route::get('{id}/show/{client}', 'EventsController@show')->name('show');


    Route::get('list/{type}/{client}', 'EventsController@eventList')->name('list');
    Route::get('{id}/show/{client}', 'EventsController@show')->name('show');
    Route::get('{id}/edit/{client}', 'EventsController@edit')->name('edit');
    Route::put('/{id}', 'EventsController@update')->name('update');

    Route::get('spaces/{idevento}', 'EventsController@spaces')->name('spaces');
    Route::post('schedules', 'SchedulesController@store')->name('schedules');
    Route::post('schedules/{id}/update', 'SchedulesController@update')->name('schedules-update');
    Route::delete('schedules/{id}/destroy/', 'SchedulesController@destroy')->name('schedules-destroy');
    Route::get('schedules/spaces/{date}/{init}/{end}/{event_id}', 'SchedulesController@getSpacesFromSchedules')->name('schedules-spaces'); //ajax requisition
});

