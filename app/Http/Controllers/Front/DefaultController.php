<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Modules;
use App\Models\FrontMenuId;
use App\Models\FrontMenu;
use View;
use Validator;
use Session;
use Request;
use Redirect;
use Illuminate\Support\Facades\Input;


class DefaultController extends Controller
{
   public function __construct()
   {
       // $this->middleware('auth', ['except' => '/']);
       // Redirect::to('csdcsd')->send();
       if ((Request::segment(1) !== 'ro') && (Request::segment(1) !== 'ru')) {
           Redirect::to('ro'.$_SERVER['REQUEST_URI'])->send();
       }
       // dd($_SERVER['REQUEST_URI']);
       // $url = $_SERVER['REQUEST_URI'];
       // $this->redirectTo($url);
       View::share('menus', $this->getMenu());
   }

   // public function redirectTo($url)
   // {
   //     if ($url == '/agentie-de-publicitate-online/retele-de-socializare') { redirect(''); }
   // }


   public function getMenu()
   {
        $frontMenus = FrontMenuId::where('p_id', 0)->orderBy('position', 'asc')->get();
        if (!empty($frontMenus)) {
            $menus = [];
            foreach ($frontMenus as $key => $frontMenu) {
                $menus[] = FrontMenu::where('lang_id', $this->lang()['lang_id'])
                                    ->where('front_menu_id', $frontMenu->id)
                                    ->first();
            }
        }

        return $menus;
   }

   public function orderCall()
   {
       $item = Validator::make(Input::all(), [
           'name' => 'required',
           'email' => 'required',
       ]);


       if($item->fails()){
           dd('bmfg');
           return redirect()->back();
       }

       $email = 'info@likemedia.com';
       // $email = 'iovitatudor@gmail.com';

       $message = '<html><body>';
       $message = '<h2>Comanda un sunet</h2>';
       $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';

       $message .= "<tr><td><strong>Nume:</strong> </td><td>" . strip_tags(Input::get('name')) . "</td></tr>";
       $message .= "<tr><td><strong>Numar de telefon:</strong> </td><td>" . strip_tags(Input::get('phone')) . "</td></tr>";
       $message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags(Input::get('email')) . "</td></tr>";
       $message .= "<tr><td><strong>Data:</strong> </td><td>" . strip_tags(date('y-m-d H:i')) . "</td></tr>";


       $to = '<'.$email.'>';
               $subject = 'info@likemedia.com';
               $message = $message;
               $header = "From: <info@likemedia.com>\r\n";
               $header.= "MIME-Version: 1.0\r\n";
               $header.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
               $header.= "X-Priority: 1\r\n";

       mail($to, $subject, $message, $header, '-fregimalimentar@unicasport.md');

       Session::flash('success', "Va multumim, in scurt timp vom lua legatura cu Dumneavoastra.");
       return redirect()->back();

   }

   public function applyNow()
   {
       $item = Validator::make(Input::all(), [
           'name' => 'required',
           'email' => 'required',
       ]);

       if($item->fails()){
           return redirect()->back();
       }

       $email = 'info@likemedia.com';
       // $email = 'iovitatudor@gmail.com';

       $message = '<html><body>';
       $message = '<h2>Aplica Acum</h2>';
       $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';

       $message .= "<tr><td><strong>Nume:</strong> </td><td>" . strip_tags(Input::get('name')) . "</td></tr>";
       $message .= "<tr><td><strong>Numar de telefon:</strong> </td><td>" . strip_tags(Input::get('phone')) . "</td></tr>";
       $message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags(Input::get('email')) . "</td></tr>";
       $message .= "<tr><td><strong>Data:</strong> </td><td>" . strip_tags(date('y-m-d H:i')) . "</td></tr>";


       $to = '<'.$email.'>';
               $subject = 'info@likemedia.com';
               $message = $message;
               $header = "From: <info@likemedia.com>\r\n";
               $header.= "MIME-Version: 1.0\r\n";
               $header.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
               $header.= "X-Priority: 1\r\n";

       mail($to, $subject, $message, $header, '-fregimalimentar@unicasport.md');

       Session::flash('success', "Va multumim, in scurt timp vom lua legatura cu Dumneavoastra.");
       return redirect()->back();

   }
}
