<?php

namespace App\Providers;

use App\Helpers\Helpers;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

//        Permet de lancer les migrations sur les sous domaines
//        Helpers::autoMigrateDomains();
//        Permet de definir l'environement par defaut
//        Helpers::setGlobalDbInstanceEnv();


    }
}
