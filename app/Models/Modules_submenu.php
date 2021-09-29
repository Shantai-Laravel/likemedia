<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modules_submenu extends Model
{
    protected $table = 'modules_submenu';

    public function modules(){
        return $this->hasOne('App\Models\Modules', 'id', 'modules_id');
    }

}
