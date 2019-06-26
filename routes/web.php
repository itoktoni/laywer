<?php

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

Auth::routes();
Route::group(
    [
        'middleware' =>
        [
            'auth',
            'menu',
            'action'
        ]
    ], function()
    {

        try {
            DB::connection()->getPdo();

            Route::group(['prefix' => 'dashboard'], function()
        {
            Route::match(
                [
                    'get',
                    'post'
                ], '/{code}', function($code)
                {
                    return App::make('\App\Http\Controllers\\'.ucfirst($code).'Controller')->callAction('list', []);
                });

            if(Cache::has('routing'))
                {
                    $cache_query = Cache::get('routing');
                    foreach($cache_query as $route)
                    {
                        Route::match(
                            [
                                'get',
                                'post'
                            ], $route->action_link, ucfirst($route->action_controller).'Controller@'.$route->action_function)->name($route->action_code);
                    }
                }
                else
                {
                    $cache_query = Cache::rememberForever('routing', function ()
                    {
                        return DB::table('actions')
                        ->where('action_enable', '1')
                        ->orderBy('action_sort', 'desc')
                        ->get();
                    });
                }
            });

        } catch (\Exception $e) {
               

        }
        
    });



Route::group(['middleware' => ['auth']], function()
{
    Route::group(['prefix' => 'dashboard'], function()
    {

        Route::get('groups/{code}', 'UserController@groups')->name('access_group');
        Route::get('user/reset', 'UserController@resetPassword')->name('resetpassword');
        Route::post('user/change_password', 'UserController@change_password')->name('lock');
        Route::get('permision', 'HomeController@permision')->name('permision');
        Route::match(
            [
                'get',
                'post'
            ], 'user/profile', 'UserController@showProfile')->name('profile');
    });
});

/*
developer console
*/
Route::get('console', 'HomeController@index')->name('console');
Route::get('query', 'HomeController@query')->name('query');
Route::get('filemanager', 'HomeController@filemanager')->name('filemanager');
Route::match(['get','post'],'file/{name}', 'HomeController@file')->name('file');
Route::match(['get','post'],'directory/{name}', 'HomeController@directory')->name('directory');

/*
developer configuration
*/
Route::get('home', 'HomeController@dashboard');
Route::get('dashboard', 'HomeController@dashboard')->name('home');
Route::get('master', 'HomeController@master')->name('master');
Route::get('error', 'homeController@error')->name('error');

Route::match(['get','post'],'setting', 'ConfigurationController@website')->name('website');

/*
public routes
*/
Route::get('/', 'PublicController@index')->name('beranda');
Route::post('/install', 'PublicController@install')->name('install');
Route::get('/about', 'PublicController@about')->name('about');
Route::get('/product', 'PublicController@product')->name('product');
Route::get('/solution', 'PublicController@solution')->name('solution');
Route::match(['get','post'],'contact', 'PublicController@contact')->name('contact');

/*
auth mechanizme
*/
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('reset', 'UserController@resetRedis')->name('reset');
Route::get('reboot', 'UserController@resetRouting')->name('reboot');

Route::get('/product/{slug}', 'PublicController@detail')->name('detail');

Route::match(
    [
        'get',
        'post'
    ], 'filter', function()
    {
        $use = new \App\User();

        $items = array();
        foreach($use->getFillable() as $value)
        {
            $items[] = [
                'id' => $value,
                'text' => $value
            ];
        }

        return response()->json($items);
    })->name('filter');
Route::match(
    [
        'get',
        'post'
    ], 'group_all', function()
    {
        $input = request()->get('q');
        $query = DB::table('group_users');
        $query->where("group_user_name", "LIKE", "%{$input}%");
        $items = array();

        foreach($query->get() as $value)
        {
            $items[] = [
                'id' => $value->group_user_code,
                'text' => $value->group_user_name
            ];
        }

        return response()->json($items);
    })->name('group_all');
Route::match(
    [
        'get',
        'post'
    ], 'group_module', function()
    {
        $input = request()->get('q');
        $query = DB::table('group_modules');
        $query->where("group_module_name", "LIKE", "%{$input}%");
        $items = array();

        foreach($query->get() as $value)
        {
            $items[] = [
                'id' => $value->group_module_code,
                'text' => $value->group_module_name
            ];
        }

        return response()->json($items);
    })->name('group_module');
Route::match(
    [
        'get',
        'post'
    ], 'team_all', function()
    {
        $input = request()->get('q');
        $query = DB::table('users');
        $query->where("name", "LIKE", "%{$input}%");
        $items = array();

        foreach($query->get() as $value)
        {
            $items[] = [
                'id' => $value->email,
                'text' => $value->name
            ];
        }

        return response()->json($items);
    })->name('team_all');
