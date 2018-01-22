<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\StateRepository::class, \App\Repositories\StateRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TypeRepository::class, \App\Repositories\TypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NatureRepository::class, \App\Repositories\NatureRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EventRepository::class, \App\Repositories\EventRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ClientRepository::class, \App\Repositories\ClientRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AdminRepository::class, \App\Repositories\AdminRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CollaboratorRepository::class, \App\Repositories\CollaboratorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SpaceRepository::class, \App\Repositories\SpaceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SpaceTypeRepository::class, \App\Repositories\SpaceTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CollaboratorTypeRepository::class, \App\Repositories\CollaboratorTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TaskRepository::class, \App\Repositories\TaskRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MaterialRepository::class, \App\Repositories\MaterialRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GraphicRepository::class, \App\Repositories\GraphicRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AudiovisualRepository::class, \App\Repositories\AudiovisualRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SupportRepository::class, \App\Repositories\SupportRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ScheduleRepository::class, \App\Repositories\ScheduleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\DynamicmailRepository::class, \App\Repositories\DynamicmailRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FinancialRepository::class, \App\Repositories\FinancialRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\HolidaysRepository::class, \App\Repositories\HolidaysRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BalanceRepository::class, \App\Repositories\BalanceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RecipeRepository::class, \App\Repositories\RecipeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ExpenseRepository::class, \App\Repositories\ExpenseRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BalanceNotificationRepository::class, \App\Repositories\BalanceNotificationRepositoryEloquent::class);
        //:end-bindings:
    }
}
