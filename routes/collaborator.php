<?php

Route::get('/home', 'CollaboratorsController@index')->name('home');

Route::group(['prefix' => 'events', 'as' => 'events.', 'middleware' => ['auth:collaborator']], function(){
    Route::get('list/{type}/{collaborator}', 'EventsController@eventList')->name('list');
    Route::get('{id}/show/{collaborator}', 'EventsController@show')->name('show');
    Route::get('tasks/{idevento}', 'TasksController@index')->name('tasks');
    Route::get('spaces/{idevento}', 'EventsController@eventSpacesCollaborator')->name('spaces');
    Route::put('tasks-response/{id}', 'TasksController@taskResponse')->name('task-response');
    Route::put('tasks/{id}', 'TasksController@taskResponseUpdate')->name('task-response-update');
    Route::put('tasks', 'TasksController@confirmAllocation')->name('task-allocation-confirm');
});

Route::group(['prefix' => 'tasks', 'as' => 'tasks.', 'middleware' => ['auth:collaborator']], function(){
    Route::get('allocations-not-responded', 'TasksController@allocations_not_responded')->name('not-responded');
    Route::get('confirm-schedule', 'TasksController@confirm_schedule')->name('confirm-schedule');
    Route::get('open', 'TasksController@open_tasks')->name('open');
    Route::get('show/{id}', 'TasksController@show')->name('show');
});


Route::group(['prefix' => 'settings', 'as' => 'settings.', 'middleware' => ['auth:collaborator']], function(){
   Route::get('perfil/{id}', 'CollaboratorsController@show')->name('perfil');
});




