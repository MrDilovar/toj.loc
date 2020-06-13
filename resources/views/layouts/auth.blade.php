<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5, shrink-to-fit=no" />
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tojir Panel</title>
    
    <!-- Favicons -->
    <link rel="shortcut icon" href="/img/favicon.ico">

    <link href="/lib/normalize-8.0.1.css" rel="stylesheet">
    <link href="/lib/bootstrap-4.3.1.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/open-iconic/font/css/open-iconic-bootstrap.min.css">
    <link href="/css/admin.css" rel="stylesheet">
</head>
<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <header>
        <nav class="navbar navbar-expand-sm navbar-light border-bottom">
            <div class="container">
                <a class="navbar-brand" href="{{ route('store.index') }}">Tojir Panel</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">

                        @guest

                        <li><a class="nav-link" href="{{ route('login') }}">Войти</a></li>
                        <li><a class="nav-link" href="{{ route('register') }}">Регистрация</a></li>

                        @else

                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                {{ Auth::user()->email }}
                            </a>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Выйти
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </ul>
                        </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    @yield('content')

    <footer class="footer mt-4 py-3 border-top bg-light">
        <div class="container">
            <span>© 2020 Toj.loc</span>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="/lib/jquery-3.4.1.min.js"></script>
    <script src="/lib/popper-1.14.6.min.js"></script>
    <script src="/lib/bootstrap-4.3.1.min.js"></script>
    <script src="/js/admin.js"></script>
</body>
</html>