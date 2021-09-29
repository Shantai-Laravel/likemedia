@extends('app')
@include('nav-bar')
@include('left-menu')
@section('content')

@include('speedbar')

@if($groupSubRelations->new == 1)
    @include('list-elements', [
        'actions' => [
            trans('variables.elements_list') => urlForLanguage($lang, 'memberslist'),
            trans('variables.add_element') => urlForFunctionLanguage($lang, 'clients/createClient'),
        ]
    ])
@else
    @include('list-elements', [
        'actions' => [
            trans('variables.elements_list') => urlForLanguage($lang, 'memberslist'),
        ]
    ])
@endif

@if(!$clients->isEmpty())
    <table class="el-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Создан</th>
                <th>Имя пользователя</th>
                <th>Email</th>
                <th>Статус</th>
                <th>{{trans('variables.edit_table')}}</th>
                @if($groupSubRelations->del_to_rec == 1 || $groupSubRelations->del_from_rec == 1)
                    <th>{{trans('variables.delete_table')}}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>#{{ $client->id }}</td>
                    <td>{{ $client->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{$client->name}}</td>
                    <td>{{$client->user_email}}</td>
                    <td>{{$client->status}}</td>
                    <td>
                        <a href="{{url($lang.'/back/front_user/list/editClient/'.$client->id)}}"><i class="fa fa-edit"></i></a>
                    </td>
                    @if($groupSubRelations->del_to_rec == 1 || $groupSubRelations->del_from_rec == 1)
                        <td class="destroy-element"><a href="{{url($lang.'/back/front_user/list/destroyClient/'.$client->id)}}"><i class="fa fa-trash"></i></a></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan=7></td>
            </tr>
        </tfoot>
    </table>
@else
    <div class="empty-response">{{trans('variables.list_is_empty')}}</div>
@endif
@stop

@section('footer')
    <footer>
        @include('footer')
    </footer>
@stop
