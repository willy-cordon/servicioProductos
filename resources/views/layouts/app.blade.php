<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME', '') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{  asset('assets/styles/css/themes/lite-'.env('THEME', 'purple').'.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="icon" href="{{ asset('/img/market.png') }}" type="image/x-icon"/>
</head>
<body>
{{--    <div class="auth-layout-wrap" style="background-image: url({{asset('img/broobe-bk.jpg')}})">--}}
    <div class="auth-layout-wrap" >
        <div class="auth-content">
            @yield('main-content')
        </div>
    </div>
    <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
    <script src="{{asset('assets/js/script.js')}}"></script>
</body>
</html>
