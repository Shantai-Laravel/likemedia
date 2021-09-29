<?php

//function urlForAction($action = 'index')
//{
//    return url(Request::segment(1) .'/'. Request::segment(2) .'/'. Request::segment(3) .'/'. $action);
//}
//
//function urlForFunction($action = 'index'){
//    return url(Request::segment(1) .'/'. Request::segment(2) .'/'. $action);
//}
//
//function urlForActionBreadcrumbs($action = 'index')
//{
//    return url(Request::segment(1) .'/'. Request::segment(2) .'/'. str_replace("-options","",Request::segment(3)) .'/'. $action);
//}


function longUrlForLanguage($lang, $action = 'index')
{
    return url($lang .'/'. Request::segment(2) .'/'. Request::segment(3) .'/'. Request::segment(4) .'/'. Request::segment(5) .'/'. $action);
}

function urlForLanguage($lang, $action = 'index')
{
    return url($lang .'/'. Request::segment(2) .'/'. Request::segment(3) .'/'. Request::segment(4) .'/'. $action);
}

// function urlForLanguage($lang, $action = 'index')
// {
//     return url($lang .'/'. Request::segment(2) .'/'. Request::segment(3) .'/'. Request::segment(4) .'/'. $action);
// }

function shortUrlForLanguage($lang, $action = 'index')
{
    return url($lang .'/'. Request::segment(2) .'/'. Request::segment(3) .'/create/'. $action);
}

function urlForFunctionLanguage($lang, $action = 'index')
{
    return url($lang .'/'. Request::segment(2) .'/'. Request::segment(3) .'/'. $action);
}

function urlForLanguageBreadcrumbsAction($lang, $action = 'index')
{
    return url($lang .'/'. Request::segment(2) .'/'. str_replace("-options","",Request::segment(3)) .'/'. $action);
}

function urlForLanguageBreadcrumbs($lang, $action = 'index')
{
    return url($lang .'/'. Request::segment(2) .'/'. str_replace("-options","",Request::segment(3)) .'/'. Request::segment(4) .'/'. $action);
}


/**
 * Verify if element has name
 * @param $id
 * @param $lang_id
 * @param $table
 * @return mixed
 */
function IfHasName($id, $lang_id, $table){
    $table_id=$table."_id";

    $row = DB::table($table)
        ->select('name')
        ->where($table_id, $id)
        ->where('lang_id', $lang_id)
        ->first();

    if(!is_null($row)){
        $row = $row->name;
    }
    else {
        $row = '';
    }
    return $row;
}

/**
 * Get max value of position
 * @param $table
 * @return mixed
 */
function GetMaxPosition($table){

    $row = DB::table($table)
       ->max('position');

    return $row;
}

/**
 * Verify if element has child
 * @param $id
 * @param $table
 * @param null $active
 * @param null $deleted
 * @return mixed
 */
function IfHasChild($id, $table, $active=null, $deleted=null){
    if (is_null($active)){
        $active = 1;
    }
    if (is_null($deleted)){
        $deleted = 0;
    }
    $row = DB::table($table)
        ->join('menu', 'menu.menu_id', '=', $table.'.id')
        ->where('p_id', $id)
        ->where('active', $active)
        ->where('deleted', $deleted)
        ->get();

    return $row;
}

/**
 * Resize image by max size
 */
function resizeIMGbyMaxSize($relative_path_to_file, $relative_output_to_file, $file_name, $maxsize, $rgb=0xFFFFFF, $quality=90){

    $src = DOC_ROOT.$relative_path_to_file.$file_name;
    $dest = DOC_ROOT.$relative_output_to_file.$file_name;

    if (!file_exists($src)) return false;

    $size = @getimagesize($src);


    if ($size === false) return false;

    $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
    $icfunc = "imagecreatefrom" . $format;
    if (!function_exists($icfunc)) return false;

    if ($size[0]>$size[1])
    {
        $ratio = $size[0]/$size[1];

        $new_width = $maxsize;
        $new_height  = floor ($maxsize/$ratio);
    }
    else
    {
        $ratio = $size[1]/$size[0];

        $new_height = $maxsize;
        $new_width = floor ($maxsize/$ratio);
    }

    $isrc = $icfunc($src);
    $idest = imagecreatetruecolor($new_width, $new_height);

    imagefill($idest, 0, 0, $rgb);
    imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $new_width, $new_height, $size[0], $size[1]);

    imagejpeg($idest, $dest, $quality);

    imagedestroy($isrc);
    imagedestroy($idest);

    return true;

}

/**
 * @param $menu_id
 * @return null
 */
function GetPidId($menu_id, $table){
    $query = DB::table($table)
        ->select('p_id')
        ->where('id', $menu_id)
        ->first();
    if(!is_null($query)){
        $query = $query->p_id;
    }
    else{
        $query = null;
    }
    return $query;
}

/**
 * @param $lang_id
 * @param $id
 * @param null $curr_id
 * @return string
 */
function SelectTree($lang_id, $id, $curr_id=null){

    $menu_id_by_level = DB::table('menu_id')
        ->where('deleted', 0)
        ->where('p_id', $id)
        ->orderBy('level', 'asc')
        ->get();

    $menu_by_level = [];
    foreach($menu_id_by_level as $key => $one_menu_id_by_level) {

        $menu_by_level[$key] = DB::table('menu')
            ->join('menu_id', 'menu.menu_id', '=', 'menu_id.id')
            ->where('menu_id', $one_menu_id_by_level->id)
            ->where('lang_id', $lang_id)
            ->first();
    }

    $item = "";
    foreach($menu_by_level as $key => $one_menu_by_level){
        if(!empty($one_menu_by_level)) {
            if ($one_menu_by_level->menu_id == $curr_id) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }

                $item .= "<option value=\"$one_menu_by_level->menu_id\" $selected>" . str_repeat("*", $one_menu_by_level->level) ." ". $one_menu_by_level->name. "</option>" . SelectTree($lang_id, $one_menu_by_level->menu_id, $curr_id);
        }

    }

    return $item;
}

/**
 * @param $lang_id
 * @param $id
 * @param null $curr_id
 * @return string
 */
function SelectGoodsSubjectTree($lang_id, $id, $curr_id=null){

    $menu_id_by_level = DB::table('goods_subject_id')
        ->where('deleted', 0)
        ->where('p_id', $id)
        ->orderBy('level', 'asc')
        ->get();

    $menu_by_level = [];
    foreach($menu_id_by_level as $key => $one_menu_id_by_level) {

        $menu_by_level[$key] = DB::table('goods_subject')
            ->join('goods_subject_id', 'goods_subject.goods_subject_id', '=', 'goods_subject_id.id')
            ->where('goods_subject_id', $one_menu_id_by_level->id)
            ->where('lang_id', $lang_id)
            ->first();
    }

    $item = "";
    foreach($menu_by_level as $key => $one_menu_by_level){
        if(!empty($one_menu_by_level)) {
            if ($one_menu_by_level->goods_subject_id == $curr_id) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            if(empty(CheckIfSubjectHasItems('goods', $one_menu_by_level->goods_subject_id))){
                $disabled = '';
            }
            else {
                $disabled = 'disabled';
            }

            $item .= "<option value=\"$one_menu_by_level->goods_subject_id\" $selected $disabled>" . str_repeat("*", $one_menu_by_level->level) ." ". $one_menu_by_level->name. "</option>" . SelectGoodsSubjectTree($lang_id, $one_menu_by_level->goods_subject_id, $curr_id);
        }

    }

    return $item;
}

/**
 * @param $lang_id
 * @param $id
 * @param null $curr_id
 * @return string
 */
function SelectGoodsItemTree($lang_id, $id, $curr_id=null){

    $menu_id_by_level = DB::table('goods_subject_id')
        ->where('deleted', 0)
        ->where('p_id', $id)
        ->orderBy('level', 'asc')
        ->get();

    $menu_by_level = [];
    foreach($menu_id_by_level as $key => $one_menu_id_by_level) {

        $menu_by_level[$key] = DB::table('goods_subject')
            ->join('goods_subject_id', 'goods_subject.goods_subject_id', '=', 'goods_subject_id.id')
            ->where('goods_subject_id', $one_menu_id_by_level->id)
            ->where('lang_id', $lang_id)
            ->first();
    }

    $item = "";
    foreach($menu_by_level as $key => $one_menu_by_level){
        if(!empty($one_menu_by_level)) {
            if ($one_menu_by_level->goods_subject_id == $curr_id) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            if(!empty(CheckIfSubjectHasItems('goods', $one_menu_by_level->goods_subject_id)) || empty(IfHasChildUniv($one_menu_by_level->goods_subject_id, 'goods_subject', 1, 0))){
                $disabled = '';
            }
            else {
                $disabled = 'disabled';
            }
            $item .= "<option value=\"$one_menu_by_level->goods_subject_id\" $selected $disabled>" . str_repeat("*", $one_menu_by_level->level) ." ". $one_menu_by_level->name. "</option>" . SelectGoodsItemTree($lang_id, $one_menu_by_level->goods_subject_id, $curr_id);
        }

    }
    return $item;
}

/**
 * @param $id
 * @param $table
 * @return null
 */
function GetLevel($id, $table){
    $query = DB::table($table)
        ->where('id', $id)
        ->first();

    if(!is_null($query)){
        $query = $query->level;
    }
    else{
        $query = null;
    }

    return $query;
}

/**
 * @param $menu_id
 * @param $table
 * @return null
 */
function GetParentAlias($menu_id, $table){
    $p_id = GetPidId($menu_id, $table);

    $query = DB::table($table)
        ->where('id', $p_id)
        ->first();

    if(!is_null($query)){
        $query = $query->alias;
    }
    else{
        $query = null;
    }

    return $query;
}

/**
 * @param $id
 * @param $table
 * @param null $active
 * @param null $deleted
 * @return mixed
 */
function IfGoodsHasChild($id, $table, $active=null, $deleted=null){
    $table_id = $table . '_id';

    if (is_null($active)){
        $active = 1;
    }
    if (is_null($deleted)){
        $deleted = 0;
    }
    $row = DB::table($table_id)
        ->join($table, $table.'.'.$table_id, '=', $table_id.'.id')
        ->where('p_id', $id)
        ->where('active', $active)
        ->where('deleted', $deleted)
        ->get();

    return $row;
}

/**
 * @param $table_begin
 * @param $id
 * @return mixed
 */
function CheckIfSubjectHasItems($table_begin, $id){
    $table = $table_begin."_item_id";
    $subject = $table_begin."_subject_id";

    $query = DB::table($table)
        ->where($subject, $id)
        ->get();

    return $query;
}

/**
 * Universal function
 * Verify if element has child
 * @param $id
 * @param $table
 * @param null $active
 * @param null $deleted
 * @return mixed
 */
function IfHasChildUniv($id, $table, $active=null, $deleted=null){
    $table_id = $table.'_id';
    if (is_null($active)){
        $active = 1;
    }
    if (is_null($deleted)){
        $deleted = 0;
    }
    $row = DB::table($table)
        ->join($table_id, $table_id.'.id', '=', $table.'.'.$table_id)
        ->where('p_id', $id)
        ->where('active', $active)
        ->where('deleted', $deleted)
        ->get();

    return $row;
}

/**
 * @param $subject_id
 * @return mixed
 */
function getSubjectByItem($subject_id){

    $query = DB::table('goods_subject_id')
        ->where('id', $subject_id)
        ->where('deleted', 0)
        ->first();

    return $query;
}

function getModuleName($src, $lang){
    $query = DB::table('modules')
        ->where('src', $src)
        ->first();


    if (!is_null($query)) {
        $name = 'name_'.$lang;
        $icon = "<i class='fa ".$query->icon."'></i>";
        return $icon.'  '.$query->$name;
    }
    return '';
}

function getInfoLineName($alias, $langId){
    $row = DB::table('info_line_id')
        ->join('info_line', 'info_line_id.id', '=', 'info_line.info_line_id')
        ->where('alias', $alias)
        ->where('lang_id', $langId)
        ->first();

    $name = '';

    if (!is_null($row)) {
        $name = $row->name;
    }

    return $name;
}

function getInfoLineId($alias, $langId){
    $row = DB::table('info_line_id')
        ->join('info_line', 'info_line_id.id', '=', 'info_line.info_line_id')
        ->where('alias', $alias)
        ->where('lang_id', $langId)
        ->first();

    $id = '';

    if (!is_null($row)) {
        $id = $row->id;
    }

    return $id;
}

function countTableItems($table){
    $row = DB::table($table)
            ->get();

    return count($row);
}

function getInfoLineNameById($id, $langId)
{
   $row = DB::table('info_line_id')
        ->join('info_line', 'info_line_id.id', '=', 'info_line.info_line_id')
        ->where('info_line_id.id', $id)
        ->where('lang_id', $langId)
        ->first();

    $name = '';

    if(!is_null($row)){
        $name = $row->name;
    }

    return $name;
}

function getUserGroup($groupId)
{
    $row = DB::table('admin_user_group')
                ->where('id', $groupId)
                ->first();

    if (!is_null($row)) {
        return $row->name;
    }

    return '';
}

function getGroupNameByAlias($alias)
{
    $row = DB::table('admin_user_group')
                ->where('alias', $alias)
                ->first();
    if (!is_null($row)) {
        return $row->name;
    }

    return '';
}

function getGoodCategory($id, $langId)
{
    $row = DB::table('goods_subject_id')
        ->join('goods_subject', 'goods_subject_id.id', '=', 'goods_subject.goods_subject_id')
        ->where('goods_subject_id.id', $id)
        ->where('lang_id', $langId)
        ->first();

    $name = '';

    if(!is_null($row)){
        $name = $row->name;
    }

    return $name;
}

function getSelectedParam($goodsId, $langId, $paramId)
{
    $row = DB::table('parameter_goods')
                ->where('goods_id', $goodsId)
                ->where('param_id', $paramId)
                ->where('lang_id', $langId)
                ->first();

    if (!is_null($row)) {
        return $row->param_value;
    }

    return '';
}

function getParamId($goodsId, $langId, $paramId)
{
    $row = DB::table('parameter_goods')
                ->where('goods_id', $goodsId)
                ->where('param_id', $paramId)
                ->where('lang_id', $langId)
                ->first();

    if (!is_null($row)) {
        return $row->id;
    }

    return '';
}

function getGoodName($goodId, $langId)
{
    $row = DB::table('goods_item_id')
        ->join('goods_item', 'goods_item_id.id', '=', 'goods_item.goods_item_id')
        ->where('goods_item_id', $goodId)
        ->where('lang_id', $langId)
        ->first();

    $name = '';

    if(!is_null($row)){
        $name = $row->name;
    }

    return $name;
}

function frontMenuHasChild($p_id, $lang_id)
{
    $row = DB::table('front_menu_id')
        ->join('front_menu', 'front_menu_id.id', '=', 'front_menu.front_menu_id')
        ->where('p_id', $p_id)
        ->where('lang_id', $lang_id)
        ->get();

    if (!is_null($row)) {
        return $row;
    }
    return null;
}

/**
 * Verify if element has child
 * @param $id
 * @param $table
 * @param null $active
 * @param null $deleted
 * @return mixed
 */
function IfMenuHasChild($id){
    $row = DB::table('front_menu_id')
        ->where('p_id', $id)
        ->get();

    if(!empty($row)){
        return $row;
    }else{
        return false;
    }
}

/**
 * Verify if element has child
 * @param $id
 * @param $table
 * @param null $active
 * @param null $deleted
 * @return mixed
 */
function getMenuChilds($p_id, $langId){
    $row = DB::table('front_menu_id')
        ->where('p_id', $p_id)
        ->orderBy('position', 'asc')
        ->get();

    $arr = [];

    foreach ($row as $key => $value) {
        $arr[] = DB::table('front_menu')
            ->where('lang_id', $langId)
            ->where('front_menu_id', $value->id)
            ->first();
    }
    return $arr;
}

function Label($id, $lang_id){
    $row = DB::table('labels')
        ->where('labels_id', $id)
        ->where('lang_id', $lang_id)
        ->first();

    if (!is_null($row)) {
        return $row->name;
    }

    return "label- ".$id;
}

function getLangLink($pageSlug, $lang){
    $currentLang = DB::table('lang')
                ->where('lang', $lang)
                ->first();

    $curentUrl = str_replace("/ ", "", \Request::segment(2));

    if (!is_null(\Request::segment(3))) {
        $curentUrl = str_replace("/ ", "", \Request::segment(2).'/'.\Request::segment(3));
    }

    if (!is_null(\Request::segment(4))) {
        $curentUrl = str_replace("/ ", "", \Request::segment(2).'/'.\Request::segment(3).'/'.\Request::segment(4));
    }

    if (!is_null($lang)) {
        $row = DB::table('front_menu_id')
            ->join('front_menu', 'front_menu_id.id', '=', 'front_menu.front_menu_id')
            ->where('link', $curentUrl)
            ->first();


        if (!is_null($row)) {

            $row1 = DB::table('front_menu_id')
                ->join('front_menu', 'front_menu_id.id', '=', 'front_menu.front_menu_id')
                ->where('front_menu_id', $row->front_menu_id)
                ->where('lang_id', $currentLang->id)
                ->first();

                $link = '/'.$lang.'/'.$row1->link;
            return $link;
        }
        return null;
    }
}

function getTagsList($langId){
    $articles = DB::table('info_item')
                ->where('lang_id', $langId)
                ->get();

    $tags = [];
    foreach ($articles as $key => $article) {

        $tags[] = mb_strtolower(trim($article->tag1));
        $tags[] = mb_strtolower(trim($article->tag2));
        $tags[] = mb_strtolower(trim($article->tag3));
        $tags[] = mb_strtolower(trim($article->tag4));
        $tags[] = mb_strtolower(trim($article->tag5));
    }

    if (count($tags) > 0) {
        return array_count_values($tags);
    }
    return 0;
}

function getFontSize($number, $all){
    $max = max($all);
    $min = min($all);
    $middle = ($max + $min) / 2;
    // $rand = rand(1, 5);
    $rand = 0;

    if ($number == $max) {
        return 15 + $rand;
    }elseif ($number == $min) {
        return 5 + $rand;
    }elseif ($number == $middle) {
        return 10 + $rand;
    }elseif(($number > $middle) && ($number < $max)){
        return 13 + $rand;
    }elseif(($number < $middle) && ($number > $min)){
        return 8 + $rand;
    }
}

// function getRandomColor(){
//     return '#'.dechex(rand(0x000, 0x999));
//     // return '#'.mt_rand(0, 255);
// }
