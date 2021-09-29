<?php

namespace App\Http\Controllers;

use App\Models\AdminUserActionPermision;
use App\Models\AdminUserGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Requests;
use App\Models\Modules;
use App\Models\Modules_submenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class RoleManager extends Controller
{
    public function __construct()
    {
        Route::currentRouteAction();
    }

    public function routeResponder($lang, $module, $submenu = null, $action = 'index',$id = null, $lang_id = null)
    {
        if (!Auth::check())
            return redirect(url($lang.'/back/auth/login'));

        $module = Modules::where([
            'src' => $module,
            ])
            ->first();

        $submodule = Modules_submenu::where([
            'src' => $submenu,
            ])
            ->first();

// Verific daca utilizatorul authentificat are dreptul sa acceseze pagina curenta
// Daca nu are drepturi pentru acea pagina, el e redirectionat pe prima pagina

        $group = User::find(Auth::user()->id)->group()->first();

        if(!is_null($submodule)){
            $permission = AdminUserActionPermision::where([
                'modules_id' => $submodule->modules_id,
                'admin_user_group_id' => $group->id
            ])->get();

            if($permission->isEmpty()) {
                return redirect($lang . '/back');
            }elseif(!$permission->isEmpty()){
                foreach($permission as $one_permission){
                    $curr_url = url()->current();
                    if($one_permission->new == 0)
                        $new = strpos($curr_url, 'create');
                    else
                        $new = false;

                    if($one_permission->save == 0)
                        $save = strpos($curr_url, 'save');
                    else
                        $save = false;

                    if($one_permission->active == 0)
                        $active = strpos($curr_url, 'changeactive');
                    else
                        $active = false;

                    if($one_permission->del_to_rec == 0)
                        $del_to_rec = strpos($curr_url, 'destroy');
                    else
                        $del_to_rec = false;

                    if($one_permission->del_from_rec == 0)
                        $del_from_rec = strpos($curr_url, 'destroy');
                    else
                        $del_from_rec = false;

                    if(($new || $save || $active || $del_from_rec || $del_to_rec) !== false){
                        Session::flash('error-message', 'You do not have enough rights for modify this item! ');
                        return redirect()->back();
                    }
                }
            }
        }
        elseif(!is_null($module)){
            $permission = AdminUserActionPermision::where([
                'modules_id' => $module->id,
                'admin_user_group_id' => $group->id
            ])->get();

            if($permission->isEmpty()){
                return redirect($lang.'/back');
            }elseif(!$permission->isEmpty()){
                foreach($permission as $one_permission){
                    $curr_url = url()->current();
                    if($one_permission->new == 0)
                        $new = strpos($curr_url, 'create');
                    else
                        $new = false;

                    if($one_permission->save == 0)
                        $save = strpos($curr_url, 'save');
                    else
                        $save = false;

                    if($one_permission->active == 0)
                        $active = strpos($curr_url, 'changeactive');
                    else
                        $active = false;

                    if($one_permission->del_to_rec == 0)
                        $del_to_rec = strpos($curr_url, 'destroy');
                    else
                        $del_to_rec = false;

                    if($one_permission->del_from_rec == 0)
                        $del_from_rec = strpos($curr_url, 'destroy');
                    else
                        $del_from_rec = false;

                    if(($new || $save || $active || $del_from_rec || $del_to_rec) !== false){
                        Session::flash('error-message', 'You do not have enough rights for modify this item! ');
                        return redirect()->back();
                    }
                }
            }

        }
        else{
            return redirect($lang.'/back');
        }

        if (!empty($submodule->controller)) {
            $controller = app()->make('App\Http\Controllers\Admin\\' . $submodule->controller);
            return app()->call([$controller, $action], [$id, $lang_id]);
        } elseif (!empty($module->controller)) {
            $controller = app()->make('App\Http\Controllers\Admin\\' . $module->controller);
                return app()->call([$controller, $action], [$id, $lang_id]);
        } else {
            return redirect($lang.'/back');
        }
    }
}
