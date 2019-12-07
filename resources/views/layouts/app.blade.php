<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>
        @hasSection('title')
            @yield('title') - {{ config('app.name') }}
        @else
            {{ config('app.name') }}
        @endif
    </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
    <script defer src="{{ mix('js/app.js') }}"></script>
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <meta
        name="viewport"
        content="minimum-scale=1, initial-scale=1, width=device-width, shrink-to-fit=no"
    />
    @yield('head')
</head>
<body>
    @yield('body')
</body>
@stack('js')
</html>
