<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Clothes_Shop @yield('title')</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="vichea" />

    @include('admin.layouts.style')

</head>
<body class="body loading">
    @include('components.loading')
    <div id="wrapper">
        <div id="page">
            <div class="layout-wrap">
                @include('admin.layouts.left_navbar')
                <div class="section-content-right">
                    @include('admin.layouts.header')
                </div>
            </div>
        </div>
    </div>

    @include('admin.layouts.script')
</body>
</html>
