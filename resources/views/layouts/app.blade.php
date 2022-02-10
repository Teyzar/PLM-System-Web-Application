<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Power Line Monitoring</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @yield("head")
</head>

<body>
    @include('sweetalert::alert')

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white">
            <div class="container">
                <img src="{{ mix('img/logo.png') }}" class="navbar-brand p-2" style="width: 55px; height: 55px">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <a class="navbar-brand fs-3" style="color:#fd7e14; font-family: 'Source Serif 4', sans-serif"
                        href="{{ url('/') }}">
                        Power Line Monitoring
                    </a>

                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item pt-1">
                            <a class="nav-link texthover rounded-pill"
                                href="{{ route('login') }}">{{ __('Outage Records') }}</a>
                        </li>

                        @auth
                            <li class="nav-item pt-1">
                                <a class="nav-link texthover rounded-pill"
                                    href="{{ URL::to('lineman') }}">{{ __('Accounts') }}</a>
                            </li>

                            <li class="nav-item pt-1">
                                <a class="nav-link texthover rounded-pill"
                                    href="{{ URL::to('units') }}">{{ __('Units') }}</a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto text-warning">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item pt-1">
                                    <a class="nav-link texthover rounded-pill"
                                        href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item d-none ">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown pt-1 ">
                                <a id="navbarDropdown"
                                    class="nav-link dropdown-toggle text-capitalize texthover rounded-pill" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/password">
                                        <i class="bi bi-key fs-5 px-2"></i>{{ __('Password') }}
                                    </a>
                                    <a class="dropdown-item" href=""
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right fs-5 px-2"></i>{{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield("content")
        </main>

    </div>

    @yield('body')

</body>

</html>
