<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Modules;
use App\Models\InfoLineId;
use App\Models\InfoLine;
use App\Models\InfoItemId;
use App\Models\InfoItem;
use App\Http\Controllers\Front\DefaultController;


class BlogController   extends DefaultController
{
    public function index()
    {
        $articlesId = InfoItemId::where('deleted', 0)
                                ->where('active', 1)
                                ->orderBy('id', 'desc')
                                ->get();

        $articles = [];
        if (!empty($articlesId)) {
            foreach ($articlesId as $key => $articleId) {
                $articles[] = InfoItem::where('lang_id', $this->lang()['lang_id'])
                                    ->where('info_item_id', $articleId->id)
                                    ->first();
            }
        }

        $infoLine = InfoLine::where('lang_id', $this->lang()['lang_id'])
                            ->where('info_line_id', 1)
                            ->first();

        $title = "Blog";
        $descr = "descr";
        $keywords = "keywords";

        if (!is_null($infoLine)) {
            $title = $infoLine->meta_title;
            $descr = $infoLine->meta_description;
            $keywords = $infoLine->meta_keywords;
        }

        $data['articles'] = $articles;
        $data['title'] = $title;
        $data['description'] = $descr;
        $data['keywords'] = $keywords;
        return view('front.blog', $data);
    }

    public function article($lang, $alias)
    {
        $articleId = InfoItemId::where('deleted', 0)
                                ->where('active', 1)
                                ->where('alias', $alias)
                                ->first();

        $article = "";
        if (!is_null($articleId)) {
            $article = InfoItem::where('lang_id', $this->lang()['lang_id'])
                                ->where('info_item_id', $articleId->id)
                                ->first();

        }

        $data['article'] = $article;
        $data['title'] = $article->meta_title;
        $data['description'] = $article->meta_description;
        $data['keywords'] = $article->meta_keywords;
        return view('front.blogSingle', $data);
    }

    public function getByKeyword($lang, $keyword)
    {

        $articles = InfoItem::where('lang_id', $this->lang()['lang_id'])
                            ->where('tag1', $keyword)
                            ->orWhere('tag2', $keyword)
                            ->orWhere('tag3', $keyword)
                            ->orWhere('tag4', $keyword)
                            ->orWhere('tag5', $keyword)
                            ->get();

        $infoLine = InfoLine::where('lang_id', $this->lang()['lang_id'])
                            ->where('info_line_id', 1)
                            ->first();

        $title = "Blog";
        $descr = "descr";
        $keywords = "keywords";

        if (!is_null($infoLine)) {
            $title = $infoLine->meta_title;
            $descr = $infoLine->meta_description;
            $keywords = $infoLine->meta_keywords;
        }

        $data['articles'] = $articles;
        $data['title'] = $title;
        $data['description'] = $descr;
        $data['keywords'] = $keywords;
        return view('front.blog', $data);
    }
}
