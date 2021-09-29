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

    @if(!is_null($client))
    <form class="form-reg"  role="form" method="POST" action="{{ urlForLanguage($lang, 'updateitem/'.$client->id) }}" id="add-form" enctype="multipart/form-data">
        <div class="part left-part">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <ul>
                <li>
                    <label for="name">{{trans('variables.name_text')}}</label>
                    <input type="text" name="name" id="name" value="{{ $client->name }}">
                </li>
                 <li>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ $client->user_email }}">
                </li>
                <li>
                    <label for="password">Новый пароль</label>
                    <input type="password" name="password" id="password">
                </li>
                <li>
                    <label for="password_again">Повторите пароль</label>
                    <input type="password" name="password_again" id="password_again">
                </li>
                
            </ul>
        </div>
        <div class="part right-part">
            <ul>
                <li>
                    <label for="status">Создан</label>
                    <div>
                        <a class="text-primary">{{ $client->created_at->format('d.m.y H:i') }}</a>
                    </div>
                </li>
                <li>
                    <label for="status">Обновлён</label>
                    <div>
                        <a class="text-primary">{{ $client->updated_at->format('d.m.y H:i') }}</a>
                    </div>
                </li>
                <li>
                    <label for="status">Статус</label>
                    <select name="status" id="status">
                        <option value="active" {{ $client->status == 'active' ? 'selected' : '' }}>Активен</option>
                        <option value="pasive" {{ $client->status == 'pasive' ? 'selected' : '' }}>Заблокирован</option>
                    </select>
                </li>
            </ul>
             @if($groupSubRelations->save == 1)
                <input type="submit" value="{{trans('variables.save_it')}}" onclick="saveForm(this)" data-form-id="add-form">
            @endif
        </div>
    </form>
    @endif

</div>
@stop

@section('footer')
    <footer>
        @include('footer')
    </footer>
@stop
