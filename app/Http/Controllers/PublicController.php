<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Helper;
use App;
use DB;
use App\Enums\OptionSlider;

class PublicController extends Controller
{

    public function __construct()
    {
        view()->share('sosmed', Helper::createOption('sosmed-api'));
        view()->share('product', Helper::createOption('product-api'));
    }

    public function index()
    {

       
        return view('welcome');
       

        // $slider = new \App\Slider();
        // $product = new \App\Product();
        // return View('frontend.'.config('website.frontend').'.pages.homepage',[
        //     'slider' => $slider->baca()->get(),
        //     'product' => $product->baca()->get(),
        // ]);
    }  

    public function member()
    {
        $slider = new \App\Slider();
        $product = new \App\Product();
        return View('frontend.'.config('website.frontend').'.pages.member',[
            'slider' => $slider->baca()->get(),
            'product' => $product->baca()->get(),
        ]);
    }  

    public function contact()
    {
        if(request()->isMethod('POST')){
            
            $data = [
                'email' => request()->get('email'),
                'name' => request()->get('name'),
                'header' => 'Notification Information From Customer',
                'desc' => request()->get('desc'),
            ];

            $from = request()->get('email');
            $name = request()->get('name');

            $request = request()->all();
            $request['message'] = request()->get('desc'); 
            $contact = new App\Contact();
            $contact->simpan($request);

            $this->validate(request(),[
                'email' => 'email|required',
                'name'  => 'required',
                'desc' => 'required',
            ]);
            try {
                    $test = Mail::send('emails.contact', $data, function($message) use ($from,$name) {
                            $message->to(config('mail.from.address'), config('mail.from.name'));
                            $message->subject('Notification Information From Customer');
                            $message->from(config('mail.from.address'), config('mail.from.name'));
                    });    

                } catch (Exception $e) {
                   // return redirect()->back();
                }

            return redirect()->back();        

        }

        return View('frontend.'.config('website.frontend').'.pages.contact')->with([
           
        ]);
    }  

    public function install(){

          if(request()->isMethod('POST')){

            $file = DotenvEditor::load('local.env');
            $file->setKey('DB_CONNECTION', request()->get('provider'));
            $file->setKey('DB_HOST', request()->get('host'));
            $file->setKey('DB_DATABASE', request()->get('database'));
            $file->setKey('DB_USERNAME', request()->get('username'));
            $file->setKey('DB_PASSWORD', request()->get('password'));
            $file->save();
            // dd(request()->get('provider'));
            $value = DotenvEditor::getValue('DB_CONNECTION');
            // dd($value);
            $file = DotenvEditor::setKey('DB_CONNECTION', request()->get('provider'));
            $file = DotenvEditor::save();
             // Config::write('database.connections', request()->get('provider'));
            dd(request()->all());
        }
         // rename(base_path('readme.md'), realpath('').'readme.md');
         return View('welcome');
    }

    public function cara_belanja()
    {
        return View('frontend.'.config('website.frontend').'.pages.cara_belanja');
    } 

    public function marketing()
    {
        $site = new \App\Site();
        $user = DB::table('users')->where('group_user','=','sales')->get(); 
        return View('frontend.'.config('website.frontend').'.pages.marketing')->with([
            'site' => $site->all(),
            'user' => $user,
        ]);;
    }  

    public function about()
    {
        $slider = new \App\Slider();
        $data = $slider->baca()
        ->Where('type', OptionSlider::about)
        ->orWhere('type',OptionSlider::talent)
        ->get();
        
        return View('frontend.'.config('website.frontend').'.pages.about')->with([
            'about' => $data,
        ]);
    }  

    public function konfirmasi()
    {
        if(request()->isMethod('POST')){

            dd(request()->all());
        }
        return View('frontend.'.config('website.frontend').'.pages.konfirmasi');
    } 

    public function product()
    {
        $product = new \App\Product();

        return View('frontend.'.config('website.frontend').'.pages.product')->with([
            'product' => $product->baca()->Where('active', '!=', 0)->get(),
        ]);
    } 

    public function solution()
    {
        $solution = new \App\Solution();

        return View('frontend.'.config('website.frontend').'.pages.solution')->with([
            'solution' => $solution->baca()->get(),
        ]);
    } 

    public function detail($slug)
    {

        if(!empty($slug)){
            $data = DB::table('products')
            ->select(['products.*', 'category.name as categoryName'])
            ->leftJoin('category', 'category.id', 'products.category_id')
            ->where('products.slug', $slug)->first();
            return View('frontend.'.config('website.frontend').'.pages.detail')->with([
                'data' => $data,
                'category' => Helper::createOption('category-api'),
                'tag' => Helper::createOption('tag-api'),
            ]);
        }

    } 

    public function single($id)
    {
        if(!empty($id)){
            $product = new \App\Product();
            $data = $product->getStock($id)->first();
            return View('frontend.'.config('website.frontend').'.pages.single')->with('data', $data);
        }

    } 

    public function segment($id)
    {
        $segmentasi = new \App\Segmentasi();
        $category = new \App\Category();
        $material = new \App\Material();
        if(!empty($id)){
            $product = new \App\Product();
            $data = $product->segment($id)->paginate(6);
            return View('frontend.'.config('website.frontend').'.pages.catalog')->with([
                'product' => $data,
                'segmentasi' => $segmentasi->baca()->get(),
                'category' => $category->baca()->get(),
                'material' => $material->baca()->get(),
            ]);
        }

    } 
}
