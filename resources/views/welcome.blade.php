<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-mat-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
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
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
            <div class="jumbotron bg-mat-secondary mb-5 jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Get Analytics For Your Baby's Antics</h1>
                    <p class="lead">Track feedings, diaper changes, expenses and more. Get started today!</p>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div id="content" class="col-lg-8">
                        <div class="keypoints mb-5">
                            <h1>Track your child's growth and progress</h1>
                            <p>
                                Elit ut nisi Lorem et ad eu amet Lorem mollit culpa. Fugiat et in ea veniam sint reprehenderit 
                                dolore velit consequat cillum aute aliqua amet fugiat. Occaecat do in sunt commodo fugiat 
                                veniam ullamco cillum adipisicing aliqua. Qui nisi culpa cillum duis eiusmod pariatur cillum 
                                culpa. Dolor pariatur nisi Lorem id quis dolor.
                            </p>
                            <p>
                                Elit ut nisi Lorem et ad eu amet Lorem mollit culpa. Fugiat et in ea veniam sint reprehenderit 
                                dolore velit consequat cillum aute aliqua amet fugiat. Occaecat do in sunt commodo fugiat 
                                veniam ullamco cillum adipisicing aliqua. Qui nisi culpa cillum duis eiusmod pariatur cillum 
                                culpa. Dolor pariatur nisi Lorem id quis dolor.
                            </p>
                        </div>
                        <div class="keypoints mb-5">
                            <h1>Track your child's growth and progress</h1>
                            <p>
                                Elit ut nisi Lorem et ad eu amet Lorem mollit culpa. Fugiat et in ea veniam sint reprehenderit 
                                dolore velit consequat cillum aute aliqua amet fugiat. Occaecat do in sunt commodo fugiat 
                                veniam ullamco cillum adipisicing aliqua. Qui nisi culpa cillum duis eiusmod pariatur cillum 
                                culpa. Dolor pariatur nisi Lorem id quis dolor.
                            </p>
                            <p>
                                Elit ut nisi Lorem et ad eu amet Lorem mollit culpa. Fugiat et in ea veniam sint reprehenderit 
                                dolore velit consequat cillum aute aliqua amet fugiat. Occaecat do in sunt commodo fugiat 
                                veniam ullamco cillum adipisicing aliqua. Qui nisi culpa cillum duis eiusmod pariatur cillum 
                                culpa. Dolor pariatur nisi Lorem id quis dolor.
                            </p>
                        </div>
                        <div class="keypoints mb-5">
                            <h1>Track your child's growth and progress</h1>
                            <p>
                                Elit ut nisi Lorem et ad eu amet Lorem mollit culpa. Fugiat et in ea veniam sint reprehenderit 
                                dolore velit consequat cillum aute aliqua amet fugiat. Occaecat do in sunt commodo fugiat 
                                veniam ullamco cillum adipisicing aliqua. Qui nisi culpa cillum duis eiusmod pariatur cillum 
                                culpa. Dolor pariatur nisi Lorem id quis dolor.
                            </p>
                            <p>
                                Elit ut nisi Lorem et ad eu amet Lorem mollit culpa. Fugiat et in ea veniam sint reprehenderit 
                                dolore velit consequat cillum aute aliqua amet fugiat. Occaecat do in sunt commodo fugiat 
                                veniam ullamco cillum adipisicing aliqua. Qui nisi culpa cillum duis eiusmod pariatur cillum 
                                culpa. Dolor pariatur nisi Lorem id quis dolor.
                            </p>
                        </div>
                    </div>
                    <news-aside-component class="col-lg-4"></news-aside-component>
                </div>
            </div>
        </main>

        <div class="footer-container mt-5">
            <footer class="container py-5">
                <div class="row">
                    <div class="col-12 col-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mb-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="14.31" y1="8" x2="20.05" y2="17.94"></line>
                            <line x1="9.69" y1="8" x2="21.17" y2="8"></line>
                            <line x1="7.38" y1="12" x2="13.12" y2="2.06"></line>
                            <line x1="9.69" y1="16" x2="3.95" y2="6.06"></line>
                            <line x1="14.31" y1="16" x2="2.83" y2="16"></line>
                            <line x1="16.62" y1="12" x2="10.88" y2="21.94"></line>
                        </svg>
                        <small class="d-block mb-3 text-muted">© 2017-2018</small>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Features</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="#">Cool stuff</a></li>
                            <li><a class="text-muted" href="#">Random feature</a></li>
                            <li><a class="text-muted" href="#">Team feature</a></li>
                            <li><a class="text-muted" href="#">Stuff for developers</a></li>
                            <li><a class="text-muted" href="#">Another one</a></li>
                            <li><a class="text-muted" href="#">Last time</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Resources</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="#">Resource</a></li>
                            <li><a class="text-muted" href="#">Resource name</a></li>
                            <li><a class="text-muted" href="#">Another resource</a></li>
                            <li><a class="text-muted" href="#">Final resource</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Resources</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="#">Business</a></li>
                            <li><a class="text-muted" href="#">Education</a></li>
                            <li><a class="text-muted" href="#">Government</a></li>
                            <li><a class="text-muted" href="#">Gaming</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md">
                        <h5>About</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="#">Team</a></li>
                            <li><a class="text-muted" href="#">Locations</a></li>
                            <li><a class="text-muted" href="#">Privacy</a></li>
                            <li><a class="text-muted" href="#">Terms</a></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
