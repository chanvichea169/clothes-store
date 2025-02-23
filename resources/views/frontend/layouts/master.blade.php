<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Clothes_Shop @yield('title')</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="Vichea Cassano" />
    @include('frontend.layouts.style')
</head>
<body class="gradient-bg">
    @include('frontend.layouts.header')

    @yield('content')


    @include('frontend.layouts.footer')

    @include('frontend.layouts.script')

    @stack('scripts')
    </body>
</html>
