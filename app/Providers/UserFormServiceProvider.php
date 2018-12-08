<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Office;
use App\Corporate;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserFormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('user.*', function($view){
            $view->with('offices', Office::pluck('name', 'id'));
        });

        view()->composer('office.*', function($view){
            $view->with('corporates', Corporate::pluck('corporate_name', 'id'));
        });

        view()->composer('permission.*', function($view){
            $view->with('roles', Role::pluck('name', 'id'));
        });

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
