<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUserActionPermision;
use App\Models\Modules;
use App\FrontUser;
use Illuminate\Http\Request;
use App\Models\AdminUserGroup;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Hash;


class ClientsController  extends Controller
{
    public function index()
    {
        $lang = $this->lang()['lang'];

        $clients = FrontUser::paginate(10);

        return view('admin.clients.clients', get_defined_vars());
    }

    public function createClient()
    {
        $view = 'admin.clients.createClient';

        return view($view, get_defined_vars());
    }

    public function saveitem(Request $request)
    {
        $item = Validator::make(Input::all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_again' => 'required|min:6|same:password',
        ]);

        if($item->fails()){
            return response()->json([
                'status' => false,
                'messages' => $item->messages(),
            ]);
        }

        $user_hash = substr(Input::get('password'), -3);
        $user_hash = hash('sha256', $user_hash);

        $findUser = FrontUser::where('user_email', Input::get('email'))->first();
        $array = array_filter([
                'name' => Input::get('name'),
                'status' => Input::get('status'),
                'user_email' => Input::get('email'),
                'user_hash' => $user_hash,
                'password' => Hash::make($request->input('password')),
                'remember_token' => $request->input('_token'),
            ]);


        if(!$findUser){
            FrontUser::create($array);
            
            return response()->json([
                'status' => true,
                'messages' => [Lang::get('variables.save', array(), $this->lang()['lang'])],
                'redirect' => url($this->lang()['lang'].'/back/front_user')
            ]);

        }else{
            return response()->json([
                'status' => false,
                'messages' => [0 => 'eror, here already exist this email'],
            ]);
        }
    }

    public function editClient($id)
    {
        $client = FrontUser::where('id', $id)
                        ->first();

        if (is_null($client)) {
            return redirect()->back();
        }

        $data['client'] = $client;

        return view('admin.clients.editClient', $data);
    }

    public function updateitem(Request $request, $id)
    {
        $item = Validator::make(Input::all(), [
            'name' => 'required|min:3',
            'email' => 'email',
            'password' => 'min:6',
            'password_again' => 'min:6|same:password',
        ]);

        if($item->fails()){
            return response()->json([
                'status' => false,
                'messages' => $item->messages(),
            ]);
        }

        $user_hash = substr(Input::get('password'), -3);
        $user_hash = hash('sha256', $user_hash);

        $findUser = FrontUser::where('user_email', Input::get('email'))->where('id', '!=', $id)->first();

        $array = array_filter([
                    'name' => Input::get('name'),
                    'user_email' => Input::get('email'),
                    'status' => Input::get('status'),
                    'user_hash' => $user_hash,
                    'password' => Hash::make($request->input('password')),
                    'remember_token' => $request->input('_token'),
                ]);

        if(!$findUser){
            FrontUser::where('id', $id)
                    ->update($array);

            return response()->json([
                'status' => true,
                'messages' => [Lang::get('variables.save', array(), $this->lang()['lang'])],
                'redirect' => url($this->lang()['lang'].'/back/front_user/list/editClient/'.$id)
            ]);

        }else{
            return response()->json([
                'status' => false,
                'messages' => [0 => 'error, here already exist this email'],
            ]);
        }
    }

    public function destroyClient($id)
    {
        $checkUser = FrontUser::where('id', $id)
                            ->first();

        if (is_null($checkUser)) {
            return redirect()->back();
        }

        FrontUser::where('id', $id)
                ->delete();

        return redirect($this->lang()['lang'].'/back/front_user/list');
    }
}
