<?php

namespace App\Providers;

use App\Entities\Admin;
use App\Entities\Client;
use App\Entities\Collaborator;
use App\Repositories\ClientRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()    {
        $this->registerPolicies();

        Gate::define('edit-event', function($user, $event){
            if($user->id === $event->client_id || $user->role === Admin::ROLE) return true;
            return false;
        });

        Gate::define('admin-menu', function (){
            $user = Auth::user();
            return $user->role === Admin::ROLE;
        });

        Gate::define('client-menu', function (){
            $user = Auth::user();
           return $user->role === Client::ROLE;
        });

        Gate::define('collaborator-menu', function (){
            $user = Auth::user();
            return $user->role === Collaborator::ROLE;
        });

        Gate::define('su', function (){
            $user = Auth::user();
            return $user->hasRole('su');
        });

        Gate::define('gestor', function (){
            $user = Auth::user();
            return $user->hasRole('gestor');
        });

        Gate::define('gestor_agenda', function (){
            $user = Auth::user();
            return $user->hasRole('gestor_agenda');
        });

        Gate::define('gestor_tecnico', function (){
            $user = Auth::user();
            return $user->hasRole('gestor_tecnico');
        });

        Gate::define('gestor_financeiro', function (){
            $user = Auth::user();
            return $user->hasRole('gestor_financeiro');
        });

    }
}
