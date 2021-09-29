<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    protected $table = 'modules';

    public function modules_submenu(){
        return $this->hasMany('App\Models\Modules_submenu', 'modules_id', 'id');
    }

    public function modulesPermission()
    {
        return $this->hasMany('App\Models\AdminUserActionPermision', 'modules_id', 'id');
    }


}
