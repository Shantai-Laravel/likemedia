<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Modules;

class BasketController extends FrontController
{
    public function index()
    {
        $data = [];
        return view('front.pages.basket', $data);
    }
}
