<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use Illuminate\Support\Facades\Schema;
use Thedevsaddam\LaravelSchema\Schema\Schema as Table;
use Cache;


class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //

        Schema::defaultStringLength(191);
        // if(!Cache::has('tables')){
        //     $schema = new Table;
        //     $tables = $schema->databaseWrapper->getTables();
        //     $data = [];
        //     foreach ($tables as $key => $value) {
                
        //         $data[$value] = \Schema::getColumnListing($value);
        //     }
        //     Cache::forever('tables', $data);
        // }
         
       if(config('website.secure')){
            \Illuminate\Support\Facades\URL::forceScheme('https');
       } 
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

        // $app = app()->loadEnvironmentFrom('production.env');
        // dd(env('APP_NAME'));
        // //dd(config('app.env'));
        // if(file_exists(base_path().'/env/'.config('app.env').'.env')){
        //     app()->loadEnvironmentFrom('env/'.config('app.env').'.env');
        // }

       foreach (glob(app_path().'/Helpers/*.php') as $filename){
            require_once($filename);
        }
    }

}
