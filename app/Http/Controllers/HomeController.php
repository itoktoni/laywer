<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AccessMenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Charts\Beranda;
use Alkhachatryan\LaravelWebConsole\LaravelWebConsole;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper;

// use Anchu\Ftp\Facades\Ftp;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list()
    {
        return $this->index();
    }

    public function index(){
        
         return LaravelWebConsole::show();
    }

    public function dashboard()
    {
        $akses = new AccessMenu();
        $akses->setData($akses->getData());
        $chart = new Beranda();
        $chart->labels(['One', 'Two', 'Three', 'Four']);
        $chart->dataset('My dataset', 'line', [1, 2, 3, 4]);
        $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);
       
        return view('page.home.beranda')->with(['chart' => $chart]);
    }

    public function error()
    {
        return view('page.home.home');
    }

    public function master()
    {
         return view('page.master.test');
    }

    public function configuration()
    {
        $akses = new AccessMenu();
        $akses->setData($akses->getData());
        return view('home.config');
    }

    public function permision()
    {
        return view('errors.permision');
    }

    public function filemanager()
    {

        return view('page.home.filemanager');
        /*$directory = $directories = Storage::disk('system')->directories();
        $files = $files = Storage::disk('system')->files();
        return view('page.home.query')->with([
            'data' => '',
            'name' => '',
            'directory' => $directory,
            'files' => $files,
        ]);   */
    }

    public function directory($name)
    {

    }

    public function file($name)
    {
        $data = $folder = null;
        $mode = 'txt';

        if (request()->has('folder')) {
            $folder = request()->get('folder');
        }

        session('last', $folder);

        $Storage = Storage::disk('system');

        if (request()->isMethod('POST')) {
            $Storage->put($name, request()->get('code'));
        }

        if($Storage->exists($name)){
            $data = File::get(base_path($name));
        }

        $directory = $directories = Storage::disk('system')->directories();
        $files = $files = Storage::disk('system')->files();
        return view('page.home.query')->with([
            'name' => $name,
            'data' => $data,
            'mode' => Helper::mode($name),
            'directory' => $directory,
            'files' => $files,
        ]);   
    }

    public function query()
    {
        $data = File::get(base_path('app/Http/Controllers/HomeController.php'));
        $directory = $directories = Storage::disk('system')->directories();
        $files = $files = Storage::disk('system')->files();
        return view('page.home.query')->with([
            'data' => $data,
            'directory' => $directory,
            'files' => $files,
        ]);   
        // return $test;
        // dd(nl2br($test));
        // $listing = FTP::connection()->getDirListing();
        // dd($listing);
        // dd(config('app.name'));
        // Config::write('system.name', 'http://xdlee.com');

//        $data = DB::table('actions')
        //                ->leftJoin('module_connection_action', 'actions.action_code', '=', 'module_connection_action.conn_ma_action')
        //                ->leftJoin('modules', 'module_connection_action.conn_ma_module', '=', 'modules.module_code')
        //                ->leftJoin('group_module_connection_module', 'group_module_connection_module.conn_gm_module', '=', 'modules.module_code')
        //                ->leftJoin('group_modules', 'group_modules.group_module_code', '=', 'group_module_connection_module.conn_gm_group_module')
        //                ->leftJoin('group_user_connection_group_module', 'group_user_connection_group_module.conn_gu_group_module', '=', 'group_modules.group_module_code')
        //                ->where('conn_gu_group_user', Auth::user()->group_user)
        //                ->orderBy('module_sort', 'asc')
        //                ->orderBy('action_sort', 'asc')
        //                ->toSql();
        //
        //        dd($data);
    }

}
