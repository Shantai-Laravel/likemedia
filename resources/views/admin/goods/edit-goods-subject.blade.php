@extends('app')
@include('nav-bar')
@include('left-menu')
@section('content')

@include('speedbar')

@if($groupSubRelations->new == 1)
    @if(Request::segment(5) == '' || Request::segment(4) == 'createGoodsSubject')
        @include('list-elements', [
            'actions' => [
                trans('variables.elements_list') => urlForFunctionLanguage($lang, ''),
                trans('variables.add_subject') => urlForFunctionLanguage($lang, 'createGoodsSubject/creategoodssubject'),
                trans('variables.elements_basket') => urlForFunctionLanguage($lang, 'goodsSubjectCart/goodssubjectcart'),
                trans('variables.edit_element') => urlForFunctionLanguage($lang, str_slug($goods_without_lang->name).'/editgoodssubject/'.$goods_without_lang->id.'/'.$edited_lang_id)
            ]
        ])
    @else
        @include('list-elements', [
            'actions' => [
                trans('variables.elements_list') => urlForLanguage($lang, 'memberslist'),
                trans('variables.add_subject') => urlForLanguage($lang, 'creategoodssubject'),
                trans('variables.elements_basket') => urlForLanguage($lang, 'goodssubjectcart'),
                trans('variables.edit_element') => urlForLanguage($lang, 'editgoodssubject/'.$goods_without_lang->id.'/'.$edited_lang_id)
            ]
        ])
    @endif
@else
    @if(Request::segment(5) == '' || Request::segment(4) == 'createGoodsSubject')
        @include('list-elements', [
            'actions' => [
                trans('variables.elements_list') => urlForFunctionLanguage($lang, ''),
                trans('variables.elements_basket') => urlForFunctionLanguage($lang, 'goodsSubjectCart/goodssubjectcart'),
                trans('variables.edit_element') => urlForFunctionLanguage($lang, str_slug($goods_without_lang->name).'/editgoodssubject/'.$goods_without_lang->id.'/'.$edited_lang_id)
            ]
        ])
    @else
        @include('list-elements', [
            'actions' => [
                trans('variables.elements_list') => urlForLanguage($lang, 'memberslist'),
                trans('variables.elements_basket') => urlForLanguage($lang, 'menucart'),
                trans('variables.edit_element') => urlForLanguage($lang, 'editgoodssubject/'.$goods_without_lang->id.'/'.$edited_lang_id)
            ]
        ])
    @endif
@endif

<div class="list-content">
    <form class="form-reg"  role="form" method="POST" action="{{ urlForLanguage($lang, 'savesubject/'.$goods_without_lang->id.'/'.$edited_lang_id) }}" id="add-form" enctype="multipart/form-data">
        <div class="part left-part">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <ul>
                <li>
                    <label for="name">{{trans('variables.title_table')}}</label>
                    <input type="text" name="name" id="name" value="{{$goods_elems->name or ''}}">
                </li>
                <li style="margin-top: 10px">
                    <label for="p_id">{{trans('variables.p_id_name')}}</label>
                    <select name="p_id" id="p_id">
                        <option value="0" {{ !is_null($goods_subject_id) ? (($goods_subject_id->p_id == 0) ? 'selected' : '') : ''}}>{{trans('variables.home')}}</option>
                        {!! SelectGoodsSubjectTree($lang_id, 0 ,$goods_subject_id->p_id) !!}
                    </select>
                </li>
                <li>
                    <label for="body">Описание</label>
                    <textarea name="body" id="body">{{$goods_elems->body or ''}}</textarea>
                </li>
            </ul>
        </div>
        <div class="part right-part">
            <ul>
                 <li>
                    <label for="lang">{{trans('variables.lang')}}</label>
                    <select name="lang" id="lang">
                        @foreach($lang_list as $lang_key => $one_lang)
                            <option value="{{$one_lang->id}}" {{$one_lang->id == $edited_lang_id ? 'selected' : ''}}>{{$one_lang->descr}}</option>
                        @endforeach
                    </select>
                </li>
                <li>
                    <label for="alias">{{trans('variables.alias_table')}}</label>
                    <input type="text" name="alias" id="alias" value="{{$goods_subject_id->alias or ''}}">
                </li>
                 @if($groupSubRelations->save == 1)
                    <input type="submit" value="{{trans('variables.save_it')}}" onclick="saveForm(this)" data-form-id="add-form">
                @endif
            </ul>
            <ul>
                <hr><h6>Seo Тексты</h6>
                <li>
                    <label for="h1_title">{{trans('variables.h1_title_page')}}</label>
                    <input type="text" name="h1_title" id="h1_title" autocomplete="off" value="{{$goods_without_lang->h1_title or ''}}">
                </li>
                <li>
                    <label for="meta_title">{{trans('variables.meta_title_page')}}</label>
                    <input type="text" name="meta_title" id="meta_title" autocomplete="off" value="{{$goods_without_lang->meta_title or ''}}">
                </li>
                <li>
                    <label for="meta_keywords">{{trans('variables.meta_keywords_page')}}</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" autocomplete="off" value="{{$goods_without_lang->meta_keywords or ''}}">
                </li>
                <li>
                    <label for="meta_description">{{trans('variables.meta_description_page')}}</label>
                    <input type="text" name="meta_description" id="meta_description" autocomplete="off" value="{{$goods_without_lang->meta_description or ''}}">
                </li>
            </ul>
        </div>


       
    </form>
</div>
@stop

@section('footer')
    <footer>
        @include('footer')
    </footer>
@stop
