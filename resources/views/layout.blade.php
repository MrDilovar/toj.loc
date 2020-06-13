<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tojir.loc</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="/img/favicon.ico">

    <!-- Css Styles -->
    <link rel="stylesheet" type="text/css" href="/lib/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="/lib/themify-icons/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    @include('menu')
    <div class="main">
        <div class="inner-main">
            <div class="hmenu-background"></div>
            @include('header')
            @yield('content')
            @include('footer')
        </div>
    </div>

    <script src="/js/app.bundle.js"></script>
</body>
</html>
