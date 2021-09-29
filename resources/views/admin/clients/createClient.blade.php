@extends('app')
@include('nav-bar')
@include('left-menu')
@section('content')

@include('speedbar')

@if($groupSubRelations->new == 1)
    @include('list-elements', [
        'actions' => [
            'Список пользователей' => url($lang.'/back/front_user/list'),
            'Добавить пользователя' => urlForLanguage($lang, 'creategoodsitem'),
            trans('variables.elements_basket') => urlForLanguage($lang, 'goodsitemcart')
        ]
    ])
@else
    @include('list-elements', [
        'actions' => [
            trans('variables.elements_list') => urlForLanguage($lang, 'memberslist'),
            trans('variables.elements_basket') => urlForLanguage($lang, 'menucart')
        ]
    ])
@endif
<div class="list-content">
    <form class="form-reg"  role="form" method="POST" action="{{ urlForLanguage($lang, 'saveitem') }}" id="add-form" enctype="multipart/form-data">
        <div class="part left-part">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <ul>
                <li>
                    <label for="name">{{trans('variables.name_text')}}</label>
                    <input type="text" name="name" id="name">
                </li>
                 <li>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                </li>
                <li>
                    <label for="password">{{trans('variables.password_text')}}</label>
                    <input type="password" name="password" id="password">
                </li>
                <li>
                    <label for="password_again">{{trans('variables.password_again')}}</label>
                    <input type="password" name="password_again" id="password_again">
                </li>
                
            </ul>
        </div>
        <div class="part right-part">
            <ul>
                <li>
                    <label for="status">Статус</label>
                    <select name="status" id="status">
                        <option value="active">Активен</option>
                        <option value="pasive">Заблокирован</option>
                    </select>
                </li>
            </ul>
             @if($groupSubRelations->save == 1)
                <input type="submit" value="{{trans('variables.save_it')}}" onclick="saveForm(this)" data-form-id="add-form">
            @endif
        </div>
       
    </form>
</div>
@stop

@section('footer')
    <footer>
        @include('footer')
    </footer>
@stop
