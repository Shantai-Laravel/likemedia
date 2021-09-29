<!DOCTYPE html>
<html lang="en">
    <head>
        {{-- <meta name="robots" content="nofollow,noindex" />
        <meta name="googlebot" content="noindex, nofollow" /> --}}
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ $description }}">
        <meta name="keywords" content="{{ $keywords }}">
        <title>{{ $title }}</title>

        <link href="{{ asset('front-assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('front-assets/css/fonts.css') }}" rel="stylesheet">
        <link href="{{ asset('front-assets/css/jquery.circular-carousel.css') }}" rel="stylesheet">
        <link href="{{ asset('front-assets/css/slick.css') }}" rel="stylesheet">
        <link href="{{ asset('front-assets/css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('front-assets/css/responsive.css') }}" rel="stylesheet">
        <!-- <link rel="stylesheet" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css') }}"/> -->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script src="{{ asset('front-assets/js/jquery-3.1.1.min.js') }}"></script>
        <script src="{{ asset('front-assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('front-assets/js/slick.js') }}"></script>
        <script src="{{ asset('front-assets/js/jquery.waterwheelCarousel.js') }}"></script>
        <script src="{{ asset('front-assets/js/main.js') }}"></script>

    </head>
    <body>

    <div id="wrapper">
        <div class="header-wrapper">
            <div class="main-slider"></div>
            <div class="top-space-100"></div>

            <div class="header">
                <div class="container-fluid top-menu">
                    <div class="menu-inside row">
                        <div class="col-xs-4 col-sm-2 logo">
                            <a href="/"><img src="{{ asset('front-assets/img/logo.png') }}" alt=""></a>
                        </div>

                        <div class="col-xs-8  col-sm-10 header-info">
                            <div class="col-xs-12 menu-area">
                                <span class="menu-ungle"></span>
                                <ul>
                                    @if (!empty($menus))
                                        @foreach ($menus as $key => $menu)
                                            <li class="{{ Request::segment(2) == $menu->link ? 'active' : '' }}">
                                                <a  href="/{{ $lang }}/{{ $menu->link }}">{{ $menu->name }}</a>
                                                @if (IfMenuHasChild($menu->front_menu_id))
                                                    <ul class="drop-down">
                                                        @foreach (getMenuChilds($menu->front_menu_id, $lang_id) as $key => $item)
                                                            <li><a href="/{{ $lang }}/{{ $item->link }}">{{ $item->name }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                    <span class="language">
                                        <li class="{{ Request::segment(1) == 'ru' ? "active" : "" }}"> <a href="/ru/blog" class="uk-text-uppercase"> <img src="{{ asset('front-assets/img/ru.png') }}"> </a></li>
                                        <li class="{{ Request::segment(1) == 'ro' ? "active" : "" }}"><a href="/ro/blog" class="uk-text-uppercase"> <img src="{{ asset('front-assets/img/ro.png') }}"> </a></li>
                                    </span>
                                </ul>
                            </div>

                            <div class="col-xs-12">
                                <div class="col-xs-6 address-wrapp">
                                    <div class="col-xs-6 search-block"></div>
                                    <div class="col-xs-6 phone-block">
                                        <a href="tel:+3737966626">079666626</a>
                                        <a href="tel:+3737966686">079666686</a>
                                    </div>
                                </div>
                                <div class="col-xs-6 address-wrapp">
                                    <div class="col-xs-6 email-block">
                                        <a href="mailto:{{ Label(5, $lang_id) }}">{{ Label(5, $lang_id) }}</a>
                                    </div>
                                    <div class="col-xs-6 social-block">
                                        <a href="https://www.facebook.com/likemedia.md/" class="fb"></a>
                                        <a href="skype:andts13?call" class="skype"></a>
                                        <a href="mailto:info@likemedia.md" class="gmail"></a>
                                    </div>
                                </div>
                                <span class="burger-menu">
                                    <section></section>
                                    <section></section>
                                    <section></section>
                                </span>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>

            <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57470f5f75d87ac0"></script>
            <div class="container">
                <div class="row blog">
                    <h1>{{ Label(9, $lang_id) }}</h1>

                    <div class="col-md-9">

                    @foreach ($articles as $key => $article)
                     <div class="post row">
                         <div class="col-md-5 img">
                             <img src="/upfiles/info_line/{{ $article->infoItemId->img or ''}}" alt="">
                         </div>
                         <div class="col-md-7 post-info">

                             <h2><a href="/{{$lang.'/blog/'.$article->infoItemId->alias }}">{{ $article->name }}</a></h2>
                             <p>{{ $article->descr }}</p>
                             <div class="post-detail">
                                 <span class="author">de catre <b>Like Media</b></span>
                                 <span class="time-ago">{{ date('d-m-Y', strtotime($article->infoItemId->created_at)) }}</span>
                                     <div class="links addthis_inline_share_toolbox_ccz4"></div>
                             </div>
                         </div>
                     </div>
                    @endforeach

                 </div>
                 <div class="col-md-3 sidebar">
                     <h3>{{ Label(10 ,$lang_id) }}</h3>
                     @if (count(getTagsList($lang_id)) > 0)
                        @foreach (getTagsList($lang_id) as $key => $value)
                            <a href="{{ url($lang.'/blog/search/'.$key) }}" style="font-size: {{ 10 + getFontSize($value, getTagsList($lang_id)) }}px;">{{ $key }}</a>
                        @endforeach
                     @endif
                     {{-- <a href="#"><img src="{{ asset('front-assets/img/sidebar-img.png') }}" alt=""></a> --}}
                 </div>
             </div>
        </div>
    </div>

    <div class="footer">
        <div class="col-xs-12 col-sm-4 text-center">
            <!-- InstaWidget -->
          <!-- <a href="https://instawidget.net/v/user/_officialjkt48" id="link-a95ea422a31148659ed6f1ea83ea84720e7942fc7b4f4811f88505372a865bbe">@_officialjkt48</a>
            <script src="https://instawidget.net/js/instawidget.js?u=a95ea422a31148659ed6f1ea83ea84720e7942fc7b4f4811f88505372a865bbe&width=300px"></script> -->
        </div>
        <div class="col-xs-12 col-sm-4 footer-info">
             <h3>{{ Label(4, $lang_id) }}</h3>
            <div class="col-xs-12">
                <p>{{ Label(5, $lang_id) }}</p>
                <p> <a href="tel:+37379666686">079 666 686</a> </p>
                <p> <a href="tel:+37379666626">079 666 626</a> </p>
            </div>

            <div class="col-xs-12">
                {{-- <p>{{ Label(8, $lang_id) }}</p>
                <p>{{ Label(6, $lang_id) }}</p>
                <p>{{ Label(7, $lang_id) }}</p> --}}
                <p><a href="/ro/media-md">Contacte</a></p>
                <p>www.likemedia.md</p>
            </div>
        </div>

         <div class="col-xs-12 col-sm-4 text-center">
            <!--  <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&tabs=timeline&width=340&height=500&xsall_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="300" height="460" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe> -->
        </div>
    </div>
    </div>

    </body>
</html>
