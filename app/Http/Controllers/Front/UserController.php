<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Modules;
use App\FrontUser;
use Illuminate\Routing\Redirector;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserController extends FrontController
{
    public function index()
    {
        $data = [];
        return view('front.pages.auth', $data);
    }

    public function auth(Request $request)
    {
    	$lang = $this->lang()['lang'];
        $user_hash = substr(Input::get('password'), -3);
        $user_hash = hash('sha256', $user_hash);
        $password = Input::get('password');

        $this->validate($request, [
            'password' => 'required|min:3',
        ]);

        if(!Auth::guard('persons')->attempt(['user_hash' => $user_hash, 'password' => $password])){
    		    return redirect()->back()->with('error', 'The corect password is "password" DD');
        }

        return redirect($lang. '/catalog');
    }

    public function account()
    {
        $data = [];
        return view('front.pages.account', $data);
    }

    public function logout()
    {
      Auth::guard('persons')->logout();
      return redirect()->route('home');
    }

    //Temp method
    public function register()
    {
        $data = [];
        return view('front.pages.register', $data);
    }

    public function postRegister(Request $request)
    {
        $user_hash = substr($request->input('password'), -3);
        $user_hash = hash('sha256', $user_hash);

        $this->validate($request, [
    		'password' => 'required|min:3|max:20|unique:front_users',
    	]);

        $findUser = FrontUser::where('user_hash', $user_hash)->first();

        if(!$findUser){
            FrontUser::create([
                'user_hash'=> $user_hash,
                'password' => Hash::make($request->input('password')),
                'remember_token' => $request->input('_token'),
            ]);
            dd('db insert');
        }else{
            dd('eror, here already exist this password');
        }
    }

}
