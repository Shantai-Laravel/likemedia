<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\GoodsItem;
use App\Models\GoodsItemId;
use App\Models\GoodsSubject;
use App\Models\GoodsSubjectId;
use App\Models\Lang;
use App\Models\Modules;
use View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class FrontController extends Controller
{
  public function __construct()
  {
    View::share('langsList', $this->getLangs() );
    View::share('subjects', $this->getCatalog() );
  }

  private function getCatalog()
  {
    $goods_subject_id_list = GoodsSubjectId::where('deleted', 0)
        ->where('p_id', 0)
        ->orderBy('position', 'asc')
        ->get();

    $goods_subject_list = [];
    foreach($goods_subject_id_list as $key => $one_goods_subject_id_list){
        $goods_subject_list[$key] = GoodsSubject::where('goods_subject_id', $one_goods_subject_id_list->id)
            ->first();

        static $num = 0;
        $goods_child = GoodsSubjectId::where('deleted', 0)
            ->where('p_id', $one_goods_subject_id_list->id)
            ->orderBy('position', 'asc')
            ->get();

        if($goods_child != null){

            foreach ($goods_child as $key1 => $value) {
              $goods_subject_list[$key][$num] = GoodsSubject::where('goods_subject_id', $value->id)
                  ->first();
                $num++;
              // $childSubj =  GoodsSubject::where('goods_subject_id', $value->id)
              //     ->first();
              // $goods_subject_list[$key][$key1] = [
              //   'name' => $childSubj->name,
              //
              // ];
              // $goods_subject_list[$key][$key1] = ['asd',1,2,3,];
            }
        }
    }
    return $goods_subject_list;
  }

  private function getLangs()
  {
      $currentUrl = $_SERVER['REQUEST_URI'];
      $urlArr = explode('/', $currentUrl);
      $langList = Lang::orderBy('position', 'asc')->get();

      if(count($urlArr) >= 1){
          $lang = [];
          foreach ($langList as $key => $value) {
              $lang[$key]['url'] = str_replace($urlArr[1], $value->lang, $currentUrl);
              $lang[$key]['lang'] = $value->lang;
          }
          return $lang;
      }
      return false;
  }

}
