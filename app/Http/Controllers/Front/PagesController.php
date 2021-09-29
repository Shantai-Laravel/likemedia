<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\GoodsItem;
use App\Models\GoodsItemId;
use App\Models\GoodsSubject;
use App\Models\GoodsSubjectId;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Modules;
use App\Models\Menu;
use App\Models\Menu_id;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Front\DefaultController;

class PagesController extends DefaultController
{
    public function index()
    {
        $pageId = Menu_id::where('alias', 'home')->first();

        if (is_null($pageId)) {
            return abort(404);
        }

        $page = Menu::where('menu_id', $pageId->id)
                    ->where('lang_id', $this->lang()['lang_id'])
                    ->first();
        if (is_null($page)) {
            return abort(404);
        }

        $data['page'] = $page;

        return view('front.page', $data);
    }

    public function getPage($lang, $page1, $page2 = null, $page3 = null)
    {
        if ($page3 == null) {
            $link = $page2;
            if ($page2 == null) {
                $link = $page1;
            }
        }
        $page = Menu::where('slug', $link)
                    ->where('lang_id', $this->lang()['lang_id'])
                    ->first();
        if (is_null($page)) {
            return abort(404);
        }

        $data['page'] = $page;

        return view('front.page', $data);
    }
}
