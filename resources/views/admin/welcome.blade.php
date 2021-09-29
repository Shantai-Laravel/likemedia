@extends('app')
@include('nav-bar')
@include('left-menu')
@section('content')

 <article class="dashboard-page">
    <section class="section">
        <div class="row sameheight-container">
           @if(!is_null($menu))
                @foreach($menu as $m)
                <div class="col col-xs-12 col-sm-12 col-md-6 col-xl-6 stats-col">
                    <div class="card sameheight-item stats" data-exclude="xs">
                        <div class="card-block">

                            <div class="title-block">
                                <h4 class="title"> <a href="{{url($lang.'/back',$m->src)}}">{{ $m->{'name_'.$lang} }}</a> </h4>
                                <p class="title-description"> <small>{!! $m->{'descr_'.$lang} !!}</small> </p>
                            </div>

                            <div class="row row-sm stats-container">

                                <div class="col-xs-12 col-sm-6 stat-col">
                                    <div class="stat-icon"> <i class="fa {{ $m->icon }}"></i> </div>
                                    <div class="stat">
                                        <div class="value"> {{ countTableItems($m->table_name) }} </div>
                                        <div class="name"> количество элементов </div>
                                    </div>
                                    <progress class="progress stat-progress" value="{{ countTableItems($m->table_name) }}" max="100">
                                        <div class="progress">
                                            <span class="progress-bar" style="width: 15%;"></span>
                                        </div>
                                    </progress>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 @endforeach
            @endif
            <div class="col col-xs-12 col-sm-12 col-md-6 col-xl-6 stats-col">
                <div class="card sameheight-item stats" data-exclude="xs">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="title"> <a>Импорт данных из платформы Like Media</a> </h4>
                            <p class="title-description"> <small class="text-danger">Будьте крайне осторожны в работе с этим модулем</small> </p>
                        </div>
                    </div>
                    <div class="card-block">
                        <a class="btn btn-primary" href="{{ url($lang.'/back/platform/pages') }}">Импорт данных</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</article>


@stop

@section('footer')
    <footer>
        @include('footer')
    </footer>
@stop
