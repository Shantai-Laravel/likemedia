@section('left-menu')

<aside class="sidebar">
    <div class="sidebar-container">
        <div class="sidebar-header">
            <div class="brand">
                <div class="logo"> <span class="l l1"></span> <span class="l l2"></span> <span class="l l3"></span> <span class="l l4"></span> <span class="l l5"></span> </div> Like Media Admin </div>
        </div>
        <nav class="menu">
             @if(!is_null($menu))
                <ul class="nav metismenu" id="sidebar-menu">
                    <li {{Request::segment(3) == '' ? 'class=active' : ''}}><a href="{{ url('/'.Request::segment(1).'/back') }}"><i class="fa fa-dashboard"></i> Панель Управления</a></li>
                    @foreach($menu as $m)
                        <li class="{{Request::segment(3) == $m->src ? 'active' : ''}}">
                        
                        <a class="{{ count($m->modules_submenu) > 0 ? 'drop-down' : '' }}"  href="{{url($lang.'/back', $m->src)}}" > 
                        <i class="fa {{ $m->icon }}"></i> 
                        {{ $m->{'name_'.$lang} }} {!! count($m->modules_submenu) > 0 ? '<i class="fa arrow"></i></a>' : '' !!}
                        </a>
                            @if(count($m->modules_submenu) > 0)
                                <ul class="drop-hd">
                                    @foreach($m->modules_submenu as $mod_sub)
                                        <li {{Request::url() == url($lang.'/back/'.$m->src.'/'.$mod_sub->src) ? 'class=active' : ''}}><a href="{!! url($lang.'/back/'.$m->src.'/'.$mod_sub->src) !!}" {{Request::segment(4) == $m->src ? 'class=active-menu' : ''}}>{{ $mod_sub->{'name_'.$lang} }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </nav>
    </div>
</aside>

@stop