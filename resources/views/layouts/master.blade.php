<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME', '') }}</title>
    <link rel="icon" href="{{ asset('/img/market.png') }}" type="image/x-icon"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    @yield('before-css')
    {{-- theme css --}}
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-free-5.10.1-web/css/all.css') }}">
    <link id="gull-theme" rel="stylesheet" href="{{asset('assets\fonts\iconsmind\iconsmind.css')}}">
    <link id="gull-theme" rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-'.env('THEME', 'purple').'.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    {{-- page specific css --}}
    @yield('page-css')
</head>


<body class="text-left">

<!-- Pre Loader Strat  -->
<div class='loadscreen' id="preloader">
    <div class="loader loader-bubble loader-bubble-primary">
    </div>
</div>
<!-- Pre Loader end  -->

<div class="app-admin-wrap layout-{{env('MENU_LAYOUT', 'sidebar-large')}} clearfix">
@include('layouts.header')
@include('layouts.menu.'.env('MENU_LAYOUT'))
    <div class="main-content-wrap d-flex flex-column flex-grow-1 @if(env('MENU_LAYOUT', 'sidebar-large') == 'sidebar-large') sidenav-open  flex-grow-1 @endif">
        @include('layouts.errors')
        <div class="main-content">
            @yield('main-content')
        </div>
        <div class="flex-grow-1"></div>
        @include('layouts.footer')
    </div>
</div>

{{-- common js --}}
<script src="{{mix('assets/js/common-bundle-script.js')}}"></script>
{{-- page specific javascript --}}
@yield('page-js')

{{-- theme javascript --}}
{{-- <script src="{{mix('assets/js/es5/script.js')}}"></script> --}}
<script src="{{asset('assets/js/script.js')}}"></script>
<script src="{{asset('assets/js/menu.'.env('MENU_LAYOUT', 'sidebar-large').'.js')}}"></script>


{{-- custom js --}}
<script src="{{mix('js/custom.js')}}"></script>


@yield('bottom-js')
</body>

</html>
