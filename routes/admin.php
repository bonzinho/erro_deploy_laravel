<?php

Route::get('/home', 'AdminsController@index')->name('home');

Route::group(['prefix' => 'configs', 'as' => 'configs.', 'middleware' => ['auth:admin', 'role:su|gestor']], function(){
    Route::get('hollidays', 'HolidaysController@index')->name('hollidays');
    Route::post('add_hollidays', 'HolidaysController@store')->name('add_hollidays');

    Route::post('add_admin', 'AdminsController@store')->name('add-admin');
    Route::get('list_admin', 'AdminsController@adminList')->name('list-admin');
    Route::put('deactivate_admin/{admin_id}', 'AdminsController@deactivate')->name('deactivate-admin');

    Route::get('import', function(){
        return view('admin.configs.imports.collaborators');
    })->name('import');

    Route::get('import_json', function(){
        $json = json_decode(file_get_contents(public_path('colaboradores.json')));
        foreach ($json->RECORDS as $collab){
            try{
                //UPLOAD DE PHOTO
                if($collab->foto_url != null || $collab->foto_url != ''){
                    $filename = $collab->foto_url;
                    $path = 'http://eventos.fe.up.pt/files/colabs/fotos/'.$collab->foto_url;
                    copy($path, public_path('storage/'.\App\Entities\Collaborator::photoDir() .'/'. $collab->foto_url));
                }else{
                    $collab->foto_url = 'default.png';
                }

                if($collab->tel2 != null || $collab->tel2 != ''){
                    $collab->tel = $collab->tel.' / '. $collab->tel2;
                }

                if($collab->colab_grupo == 'tec'){
                    $collab->colab_grupo = 0;
                }elseif ($collab->colab_grupo == 'hosp'){
                    $collab->colab_grupo = 1;
                }else{
                    $collab->colab_grupo = 2;
                }

                if($collab->morada == null || $collab->morada == ''){
                    $collab->morada = "Sem morada";
                }

                if($collab->bi == null || $collab->bi == ''){
                    $collab->bi = "00000000";
                }
                if($collab->nif == null || $collab->nif == ''){
                    $collab->nif = "00000000";
                }
                if($collab->nib == null || $collab->nib == ''){
                    $collab->nib = "00000000";
                }

                $insert = [
                    'name' => $collab->nome,
                    'student_number' => $collab->nr_aluno,
                    'address' => $collab->morada,
                    'postal_code' => $collab->cod_postal,
                    'locality' => $collab->localidade,
                    'phone' => $collab->tel,
                    'cc' => $collab->bi,
                    'iban' => $collab->nib,
                    'nif' => $collab->nif,
                    'locker' => $collab->cacifo,
                    'type' => $collab->colab_grupo,
                    'photo' => \App\Entities\Collaborator::photoDir().'/'.$collab->foto_url,
                    'password' => '$10$nWiZ33/Fq.5MU.F.24xrXuePUMVC30PO2OYIDnutQiKMZ9e6jBkQy',
                    'genre' => 'null',
                    'cv' => 'without_cv.pdf',
                    'email' => $collab->email,
                ];
                \App\Entities\Collaborator::firstOrNew($insert)->save();
            }catch (Exception $e){
                return $e->getMessage();
            }

        }
    })->name('import_json');
});

Route::group(['prefix' => 'events', 'as' => 'events.', 'middleware' => ['auth:admin']], function(){
    Route::get('list/{type}/{admin}', 'EventsController@eventList')->name('list');
    Route::get('{id}/show/{admin}', 'EventsController@show')->name('show');
    Route::get('{id}/edit/{admin}', 'EventsController@edit')->middleware('role:su|gestor|gestor_agenda')->name('edit');
    Route::put('/{id}', 'EventsController@update')->name('update')->middleware('role:su|gestor|gestor_agenda');
    Route::get('{id}/status/{status}', 'EventsController@changeStatus')->name('change_status'); //midleware na função
    Route::get('tasks/{idevento}', 'TasksController@index')->name('tasks');
    Route::post('tasks', 'TasksController@store')->name('tasks-created')->middleware('role:su|gestor|gestor_tecnico');
    Route::post('tasks/{id}/update', 'TasksController@update')->name('tasks-update')->middleware('role:su|gestor|gestor_tecnico');
    Route::delete('tasks/{id}/destroy/', 'TasksController@destroy')->name('tasks-destroy')->middleware('role:su|gestor|gestor_tecnico');
    Route::get('tasks/changeStatus/{state}/{id}', 'TasksController@changeStatus')->name('task_change_status')->middleware('role:su|gestor|gestor_tecnico');

    Route::get('spaces/{idevento}', 'EventsController@spaces')->name('spaces');
    Route::post('schedules', 'SchedulesController@store')->name('schedules')->middleware('role:su|gestor|gestor_agenda');
    Route::post('schedules/{id}/update', 'SchedulesController@update')->name('schedules-update')->middleware('role:su|gestor|gestor_agenda');
    Route::delete('schedules/{id}/destroy/', 'SchedulesController@destroy')->name('schedules-destroy')->middleware('role:su|gestor|gestor_agenda');
    Route::get('schedules/spaces/{date}/{init}/{end}/{event_id}', 'SchedulesController@getSpacesFromSchedules')->name('schedules-spaces'); //ajax requisition

    Route::group(['prefix' => 'tasks', 'as' => 'tasks.', 'middleware' => ['auth:admin']], function(){
        Route::post('allocate', 'TasksController@allocate')->name('allocate')->middleware('role:su|gestor|gestor_tecnico');
        Route::post('deallocate', 'TasksController@deallocate')->name('deallocate')->middleware('role:su|gestor|gestor_tecnico');
        Route::post('confirm-schedule', 'TasksController@validate_schedule')->name('validate-schedule')->middleware('role:su|gestor|gestor_tecnico');
        Route::post('change-collaborator', 'TasksController@change_collaborator')->name('change-collaborator')->middleware('role:su|gestor|gestor_tecnico');
        Route::post('validate_all_schedules/{event_id}', 'TasksController@validateAllSchedules')->name('validate-all-schedules')->middleware('role:su|gestor|gestor_tecnico');
    });

    Route::group(['prefix' => 'balance', 'as' => 'balance.', 'middleware' => ['auth:admin']], function() {
        Route::get('recipes/{id}', 'RecipesController@index')->name('recipes')->middleware('role:su|gestor|gestor_tecnico|gestor_agenda|gestor_financeiro');
        Route::post('recipes', 'RecipesController@store')->name('store-recipes')->middleware('role:su|gestor|gestor_tecnico|gestor_agenda|gestor_financeiro');
        Route::post('update_recipes/{id}', 'RecipesController@update')->name('update-recipes')->middleware('role:su|gestor|gestor_tecnico|gestor_agenda|gestor_financeiro');
        Route::delete('delete_recipes/{id}/{event_id}', 'RecipesController@destroy')->name('delete-recipes')->middleware('role:su|gestor|gestor_tecnico|gestor_agenda|gestor_financeiro');
        Route::get('total_recipes/{event_id}', 'RecipesController@total')->name('total-recipes')->middleware('role:su|gestor|gestor_tecnico|gestor_agenda|gestor_financeiro');

        Route::get('expenses/{id}', 'ExpensesController@index')->name('expenses')->middleware('role:su|gestor|gestor_tecnico|gestor_agenda|gestor_financeiro');
        Route::post('expenses', 'ExpensesController@store')->name('store-expenses')->middleware('role:su|gestor|gestor_tecnico|gestor_agenda|gestor_financeiro');
        Route::post('update_expenses/{id}', 'ExpensesController@update')->name('update-expenses')->middleware('role:su|gestor|gestor_tecnico|gestor_agenda|gestor_financeiro');
        Route::delete('delete_expenses/{id}/{event_id}', 'ExpensesController@destroy')->name('delete-expenses')->middleware('role:su|gestor|gestor_tecnico|gestor_agenda|gestor_financeiro');
        Route::get('total_expenses/{event_id}', 'ExpensesController@total')->name('total-expenses')->middleware('role:su|gestor|gestor_tecnico|gestor_agenda|gestor_financeiro');
        Route::get('add_collab-expenses/{event_id}', 'ExpensesController@addCollabExpenses')->name('add-collab-expenses')->middleware('role:su|gestor|gestor_tecnico');

        Route::post('close_tech_balance/{id}', 'EventsController@close_tech_balance')->name('close-tech-balance')->middleware('role:su|gestor_financeiro');
        Route::post('close_sche_balance/{id}', 'EventsController@close_sche_balance')->name('close-sche-balance')->middleware('role:su|gestor_financeiro');

        Route::get('balance_state/{id}', 'EventsController@balance_state')->name('balance-state');
        Route::get('notify_client/{id}', 'EventsController@balance_notify_client')->name('notify-client')->middleware('role:su|gestor_financeiro');

        Route::get('close_internal_sche_balance/{id}', 'EventsController@close_internal_sche_balance')->name('close-internal-sche-balance')->middleware('role:su|gestor|gestor_tecnico|gestor_agenda');
        Route::get('close_internal_tech_balance/{id}', 'EventsController@close_internal_tech_balance')->name('close-internal-tech-balance')->middleware('role:su|gestor|gestor_tecnico|gestor_agenda');

    });

});

Route::group(['prefix' => 'collaborators', 'as' => 'collaborators.', 'middleware' => ['auth:admin']], function(){
    Route::post('disable/{id}', 'CollaboratorsController@deactivate')->name('deactivate')->middleware('role:su|gestor|gestor_tecnico');
    Route::post('activate/{id}', 'CollaboratorsController@activate')->name('activate')->middleware('role:su|gestor|gestor_tecnico');
    Route::post('send_msg/{id}', 'CollaboratorsController@sendMessage')->name('send-msg')->middleware('role:su|gestor|gestor_tecnico');
    Route::get('listActive', 'CollaboratorsController@listActive')->name('list')->middleware('role:su|gestor|gestor_tecnico');
    Route::get('{id}/show', 'CollaboratorsController@showAdmin')->name('show')->middleware('role:su|gestor|gestor_tecnico');
    Route::get('create', 'CollaboratorsController@create')->name('create')->middleware('role:su|gestor|gestor_tecnico');
    Route::post('store', 'CollaboratorsController@store')->name('store')->middleware('role:su|gestor|gestor_tecnico');
    Route::get('dynamic-email', 'CollaboratorsController@dynamicEmail')->name('dynamic_email')->middleware('role:su|gestor|gestor_tecnico');
    Route::post('dynamic-email', 'CollaboratorsController@dynamicEmailSend')->name('dynamic_email_send')->middleware('role:su|gestor|gestor_tecnico');
});

Route::group(['prefix' => 'financial', 'as' => 'financial.', 'middleware' => ['auth:admin']], function(){
    Route::get('list', 'FinancialsController@index')->name('list')->middleware('role:su|gestor|gestor_financeiro');
    Route::get('payments', 'FinancialsController@payments')->name('payments')->middleware('role:su|gestor');
    Route::post('pay', 'FinancialsController@store')->name('pay')->middleware('role:su|gestor');
    Route::put('add_receipt/{id}/update', 'FinancialsController@update')->name('add_receipt')->middleware('role:su|gestor');

    Route::get('current_balance', 'EventsController@currentBalance')->name('current-balance')->middleware('role:su|gestor');

});