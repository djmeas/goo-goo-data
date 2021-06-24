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
    <nav class="navbar navbar-expand-md navbar-light bg-mat-primary shadow-sm">
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

        <main>
            <div class="jumbotron mb-5 jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Get Analytics For Your Baby's Antics</h1>
                    <p class="lead">Track feedings, diaper changes, expenses and more. Get started today!</p>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div id="content" class="col-lg-8">
                        <div class="keypoints mb-5">
                            <h1>
                                <span class="material-icons" style="font-size: 28px;">
                                insights
                                </span>
                                Track your child's growth and progress
                            </h1>
                            
                            <p>
                                How many ounces of milk did your child have last week? How much did you spend on diapers last month?
                                Easily and quickly manage entries for multiple children and review you data in a table or chart on 
                                any browser-enabled device.
                            </p>
                            <img class="d-none d-sm-block" src="/img/tracker.jpg" alt="tracker entries" width="100%">
                            <img class="d-block d-sm-none" src="/img/tracker_mobile.jpg" alt="tracker entries" width="100%">
                        </div>
                        <div class="keypoints mb-5">
                            <h1>
                                <span class="material-icons" style="font-size: 28px;">
                                supervised_user_circle
                                </span>
                                Caretaker access for sharing data
                            </h1>
                            <p>
                                Need to share data for a particular child with family member or healthcare provider? 
                                Add additional caretakers with an invitation.
                                Once they accept, they'll have access to review data and even manage and add entries as well if permitted.
                            </p>
                            <img class="d-none d-sm-block" src="/img/caretakers.jpg" alt="caretakers" width="100%">
                            <img class="d-block d-sm-none" src="/img/caretakers_mobile.jpg" alt="caretakers" width="100%">
                        </div>
                        <div class="keypoints mb-5">
                            <h1>
                                <span class="material-icons" style="font-size: 28px;">
                                verified_user
                                </span>
                                Your data is yours
                            </h1>
                            <p>
                                Goo Goo Data does not sell your data to any 3rd parties. The goal is to easily track 
                                your child's data without relying on notebooks or spreadsheets. The developer of this site 
                                recently became a father and found it cumbersome to track data and share it with others in
                                a convenient and meaningful way.
                            </p>
                        </div>
                    </div>
                    <news-aside-component class="col-lg-4"></news-aside-component>
                </div>
            </div>
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
