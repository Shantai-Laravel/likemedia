<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}">
    

    <!-- Fonts CSS file -->
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/fonts.css') }}">
    <!-- Resets CSS file -->
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/resets.css') }}">
    <!-- Main CSS file -->
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/responsive.css') }}">
    <!-- Jquery Javascript file -->
    <script src="{{ asset('front-assets/js/jquery-2.2.1.min.js') }}"></script>
    <!-- Main Javascript file -->
    <script src="{{ asset('front-assets/js/main.js') }}"></script>
    <script src="{{ asset('front-assets/js/ajax.js') }}"></script>


    <title>Malearka.md</title>

</head>
<body>

   <div id="wrapper">
       @yield('content')
   </div>

</body>
</html>
