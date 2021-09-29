<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}">
    @if(!is_null($modules_submenu_name))
        <title>{{$modules_submenu_name->{'name_'.$lang} or trans('variables.title_page')}}</title>
    @elseif(!is_null($modules_name))
        <title>{{$modules_name->{'name_'.$lang} or trans('variables.title_page')}}</title>
    @else
        <title>{{trans('variables.title_page')}}</title>
    @endif
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->
     <link rel="stylesheet" href="{{asset('css/normalize.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('css/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/chosen.css')}}">
    <link rel="stylesheet" href="{{asset('css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('css/fancybox/jquery.fancybox.css')}}">
    <link rel="stylesheet" href="{{asset('css/fancybox/jquery.fancybox-buttons.css')}}">
    <link rel="stylesheet" href="{{asset('css/fancybox/jquery.fancybox-thumbs.css')}}">
    <script src="{{asset('js/jquery-2.1.4.js')}}"></script>
    <script src="{{asset('js/jsvalidation.js')}}"></script>
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/toastr.js')}}"></script>
    <script src="{{asset('js/jquery.tablednd_0_5.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('js/chosen.jquery.js')}}"></script>
    <script src="{{asset('js/dropzone.js')}}"></script>
    <script src="{{asset('js/dropzone-config.js')}}"></script>
    <script src="{{asset('js/fancybox/jquery.fancybox.js')}}"></script>
    <script src="{{asset('js/fancybox/jquery.fancybox-buttons.js')}}"></script>
    <script src="{{asset('js/fancybox/jquery.fancybox-thumbs.js')}}"></script>
    <script src="{{asset('js/fancybox/jquery.mousewheel.js')}}"></script>
    <script src="{{asset('js/jquery.mjs.nestedSortable.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app-green.css') }}">
    <script src="{{asset('js/jquery.nestable.js')}}"></script>
    
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
     fbq('init', '515351529137897'); 
    fbq('track', 'PageView');
    </script>
    <noscript>
     <img height="1" width="1" 
    src="https://www.facebook.com/tr?id=515351529137897&ev=PageView
    &noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
    
</head>

<body>

    <div class="main-wrapper">
        <div class="app" id="app">
            <header class="header">
                @yield('nav-bar')
            </header>

        @yield('left-menu')

        <div class="sidebar-overlay" id="sidebar-overlay"></div>
        <article class="content items-list-page">
        @yield('content')
        </article>


        @yield('footer')

        </div>
    </div>

    <!-- <script src="{{ asset('js/vendor.js') }}"></script> -->
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->

</body>
</html>
