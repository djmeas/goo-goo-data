<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @guest
    @else
        <script>
            const currentUser = {
                id: {{Auth::id()}},
                name: "{{Auth::user()->first_name}} {{Auth::user()->last_name}}",
                email: "{{Auth::user()->email}}"
            };
        </script>
    @endguest

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/vue-chartjs/dist/vue-chartjs.min.js"></script>

    <!-- Get minor updates and patch fixes within a major version -->
    <script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll@15/dist/smooth-scroll.polyfills.min.js"></script>    

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <vue-confirm-dialog></vue-confirm-dialog>
        <nav class="navbar navbar-expand-md navbar-light bg-mat-primary shadow-sm mb-4">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                <span class="material-icons" style="vertical-align: sub;">
                    child_friendly
                </span>
                {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/tracker">Tracker</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/charts">Charts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/children">Children</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->first_name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/invites">Invites</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="page-contents-container py-4">
            @yield('content')
        </main>

        <div class="footer-container mt-5">
            <footer class="container py-3">
                <div class="row">
                    <div class="col-lg-4 text-center-sm-only">
                    <a class="navbar-brand py-3" href="http://goo-goo-data.test">
                        <span class="material-icons" style="vertical-align: sub;">
                            child_friendly
                        </span>
                        GOO GOO DATA
                        </a>
                    </div>
                    <div class="col-lg-4 text-center">
                        <p>
                            © Harry Meas 2021<br>
                            WGU Software Development Capstone
                        </p>
                    </div>
                    <div class="col-lg-4 text-right text-center-sm-only pt-3">
                        <a href="/about-the-developer" title="Learn about the developer">
                            <img class="mr-2 rounded-circle" src="/img/me.png"/ width="32px" alt="Harry Meas">
                        </a>
                        <a href="https://github.com/djmeas/goo-goo-data" title="View Goo Goo Data's Github page">                    
                            <img class="mr-1" src="/img/github.svg" style="filter: invert(1);" width="32px" alt="Goo Goo Data Github page">
                        </a>
                        <a href="https://vuejs.org/" title="Built using Vue.js">
                            <img class="mr-1" src="/img/vuedotjs.svg" style="filter: invert(1);" width="32px" alt="Vue.js">
                        </a>
                        <a href="https://laravel.com/" title="Built using Laravel">
                            <img class="mr-1" src="/img/laravel.svg" style="filter: invert(1);" width="32px" alt="laravel.com">
                        </a>
                        <a href="https://www.linode.com/" title="Hosted on Linode">
                            <img class="" src="/img/linode.svg" style="filter: invert(1);" width="32px" alt="linode.com">
                        </a>
                        <a href="https://www.wgu.edu/" title="WGU">
                            <img class="" src="/img/wgu.png" width="44px" alt="wgu.edu">
                        </a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
