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
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cookie;

class CatalogController extends FrontController
{
    public function index($lang, $category = "all")
    {
      // dd(Auth::guard('persons')->check());
      // dd(Auth::guard('persons')->user());

      $data['items'] = false;
      $data['viewType'] = @$_COOKIE['catalogView'] or "view-one";
      //  $data['viewType'] = "view-one";
      $lang = $this->lang()['lang'];

      if($category == "all" || $category == ""){
          $child_goods_item_list_id = GoodsItemId::where('deleted', 0)
                ->orderBy('position', 'asc')
                ->get();

        $child_goods_item_list = [];
        foreach($child_goods_item_list_id as $key => $one_goods_elem){
            $child_goods_item_list[$key] = GoodsItem::where('goods_item_id', $one_goods_elem->id)
                ->first();
            $data['items'] = $child_goods_item_list;
        }
      }else{
          $subject = GoodsSubjectId::where('deleted', 0)
                ->where('alias', $category)
                ->first();

          if($subject != null){
              $childSubjct = GoodsSubjectId::where('deleted', 0)
                    ->where('p_id', $subject->id)
                    ->get();

            $child_goods_item_list = [];
            static $i = 0;

            foreach ($childSubjct as $key1 => $value1) {
                $child_goods_item_list_id = GoodsItemId::where('deleted', 0)
                    ->where('goods_subject_id', $value1->id)
                    ->orderBy('position', 'asc')
                    ->get();

              foreach($child_goods_item_list_id as $key => $one_goods_elem){
                  $child_goods_item_list[$i] = GoodsItem::where('goods_item_id', $one_goods_elem->id)->first();
                  $i++;
              }
            }
            $data['items'] = $child_goods_item_list;
          }
      }

      return view('front.pages.catalog', $data);
    }

    public function viewCatalog(Request $request)
    {
        $type =  Input::get('type');

        // return Cookie::make('catologView', $type);
        //  Cookie::forever('catalogView', $type);

        setcookie("catalogView", $type ,time()+ 360000);
        return "ok";
    }
}
