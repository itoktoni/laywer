<?php
namespace App\Http\Controllers;

use App\Http\Middleware\AccessMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Cache;
use DB;

class ConfigurationController extends Controller
{
    public $table;
    public $key;
    public $field;
    public $model;
    public $template;
    public $rules;
    public $datatable;
    public $searching;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function website()
    {
        if (request()->isMethod('POST')) {
             
            if(request()->get('env') != 'dev'){

                $editor = DotenvEditor::load(base_path() . '/.env');
                $editor->setKey('APP_ENV', request()->get('env'))->save();
                DotenvEditor::load(base_path().'/env/'.env('APP_ENV').'.env');
            }
            
            if (request()->exists('favicon')) {
                $file   = request()->file('favicon');
                $name   = config('app.name') . '_favicon.' . $file->extension();
                $simpen = $file->storeAs('logo', $name);
                Config::write('website.favicon', $name);
            }

            if (request()->exists('logo')) {
                $file   = request()->file('logo');
                $name   = config('app.name') . '_logo.' . $file->extension();
                $simpen = $file->storeAs('logo', $name);
                Config::write('website.logo', $name);
            }

            Config::write('website.env', request()->get('env'));
            Config::write('website.address', request()->get('address'));
            Config::write('website.description', request()->get('description'));
            Config::write('website.footer', request()->get('footer'));
            Config::write('website.about', request()->get('about'));
            Config::write('website.service', request()->get('service'));
            Config::write('website.backend', request()->get('backend'));
            Config::write('website.frontend', request()->get('frontend'));
            Config::write('website.owner', request()->get('owner'));
            Config::write('website.phone', request()->get('phone'));
            Config::write('website.live', request()->get('live'));
            Config::write('website.cache', request()->get('website_cache'));
            Config::write('website.session', request()->get('website_session'));
            Config::write('website.name', request()->get('name'));
            Config::write('website.langitude', request()->get('langitude'));
            Config::write('website.latitude', request()->get('latitude'));

            if (request()->exists('debug')) {

                if (app()->environment('local')) {
                    DotenvEditor::load(base_path() . '/env/local.env')->setKey('APP_DEBUG', request()->get('debug'))->save();
                } else {
                    DotenvEditor::load(base_path() . '/env/production.env')->setKey('APP_DEBUG', request()->get('debug'))->save();
                }
            }

            if (app()->environment('local')) {

                DotenvEditor::load(base_path() . '/env/local.env')
                    ->setKey('APP_NAME', request()->get('name'))->save();
                DotenvEditor::load(base_path() . '/env/local.env')
                    ->setKey('SESSION_DRIVER', request()->get('session'))->save();
                DotenvEditor::load(base_path() . '/env/local.env')
                    ->setKey('CACHE_DRIVER', request()->get('cache'))->save();

                DotenvEditor::load(base_path() . '/env/local.env')->setKey('MAIL_FROM_NAME', request()->get('mail_name'))->save();    
                DotenvEditor::load(base_path() . '/env/local.env')->setKey('MAIL_FROM_ADDRESS', request()->get('mail_address'))->save();
                DotenvEditor::load(base_path() . '/env/local.env')->setKey('MAIL_DRIVER', request()->get('MAIL_DRIVER'))->save();
                DotenvEditor::load(base_path() . '/env/local.env')->setKey('MAIL_HOST', request()->get('MAIL_HOST'))->save();
                DotenvEditor::load(base_path() . '/env/local.env')->setKey('MAIL_USERNAME', request()->get('MAIL_USERNAME'))->save();
                DotenvEditor::load(base_path() . '/env/local.env')->setKey('MAIL_PORT', request()->get('MAIL_PORT'))->save();
                DotenvEditor::load(base_path() . '/env/local.env')->setKey('MAIL_PASSWORD', request()->get('MAIL_PASSWORD'))->save();
                DotenvEditor::load(base_path() . '/env/local.env')->setKey('MAIL_ENCRYPTION', request()->get('MAIL_ENCRYPTION'))->save();

                 DotenvEditor::load(base_path() . '/env/local.env')->setKey('DB_CONNECTION', request()->get('DB_CONNECTION'))->save();
                DotenvEditor::load(base_path() . '/env/local.env')->setKey('DB_HOST', request()->get('DB_HOST'))->save();
                DotenvEditor::load(base_path() . '/env/local.env')->setKey('DB_PORT', request()->get('DB_PORT'))->save();
                DotenvEditor::load(base_path() . '/env/local.env')->setKey('DB_DATABASE', request()->get('DB_DATABASE'))->save();
                DotenvEditor::load(base_path() . '/env/local.env')->setKey('DB_USERNAME', request()->get('DB_USERNAME'))->save();
                DotenvEditor::load(base_path() . '/env/local.env')->setKey('DB_PASSWORD', request()->get('DB_PASSWORD'))->save();

            } else {
                DotenvEditor::load(base_path() . '/env/production.env')
                    ->setKey('APP_NAME', request()->get('name'))->save();
                DotenvEditor::load(base_path() . '/env/production.env')
                    ->setKey('SESSION_DRIVER', request()->get('session'))->save();
                DotenvEditor::load(base_path() . '/env/production.env')
                    ->setKey('CACHE_DRIVER', request()->get('cache'))->save();

                DotenvEditor::load(base_path() . '/env/production.env')->setKey('MAIL_DRIVER', request()->get('MAIL_DRIVER'))->save();
                DotenvEditor::load(base_path() . '/env/production.env')->setKey('MAIL_HOST', request()->get('MAIL_HOST'))->save();
                DotenvEditor::load(base_path() . '/env/production.env')->setKey('MAIL_USERNAME', request()->get('MAIL_USERNAME'))->save();
                DotenvEditor::load(base_path() . '/env/production.env')->setKey('MAIL_PORT', request()->get('MAIL_PORT'))->save();
                DotenvEditor::load(base_path() . '/env/production.env')->setKey('MAIL_PASSWORD', request()->get('MAIL_PASSWORD'))->save();
                DotenvEditor::load(base_path() . '/env/production.env')->setKey('MAIL_ENCRYPTION', request()->get('MAIL_ENCRYPTION'))->save();

                 DotenvEditor::load(base_path() . '/env/production.env')->setKey('DB_CONNECTION', request()->get('DB_CONNECTION'))->save();
                DotenvEditor::load(base_path() . '/env/production.env')->setKey('DB_HOST', request()->get('DB_HOST'))->save();
                DotenvEditor::load(base_path() . '/env/production.env')->setKey('DB_PORT', request()->get('DB_PORT'))->save();
                DotenvEditor::load(base_path() . '/env/production.env')->setKey('DB_DATABASE', request()->get('DB_DATABASE'))->save();
                DotenvEditor::load(base_path() . '/env/production.env')->setKey('DB_USERNAME', request()->get('DB_USERNAME'))->save();
                DotenvEditor::load(base_path() . '/env/production.env')->setKey('DB_PASSWORD', request()->get('DB_PASSWORD'))->save();
            }

            session()->put('success', 'Configuration Success !');
            return redirect()->back();
        }

        $frontend = array_map('basename', File::directories(resource_path('views/frontend/')));
        $backend  = array_map('basename', File::directories(resource_path('views/backend/')));

        $akses = new AccessMenu();
        $akses->setData($akses->getData());

        if(!Cache::has('group')){
            Cache::rememberForever('group', function(){
                return DB::table('group_users')->get();
            });
        }

        $mail_driver = array("smtp", "sendmail", "mailgun", "mandrill", "ses", "sparkpost", "log", "array", "preview");

        $session_driver = ["file", "cookie", "database", "redis"];
        $cache_driver   = ["apc", "database", "file", "redis"];

        $database_driver = [
            "sqlite" => 'SQlite',
            "mysql"  => 'MySQL',
            "pgsql"  => 'PostgreSQL',
            "sqlsrv" => 'SQL Server',
        ];

        return view('page.configuration.website')->with([
            'group'           => Cache::get('group'),
            'frontend'        => array_combine($frontend, $frontend),
            'backend'         => array_combine($backend, $backend),
            'database'        => env('DB_CONNECTION'),
            'mail_driver'     => array_combine($mail_driver, $mail_driver),
            'session_driver'  => array_combine($session_driver, $session_driver),
            'cache_driver'    => array_combine($cache_driver, $cache_driver),
            'database_driver' => $database_driver,
        ]);
    }

}
