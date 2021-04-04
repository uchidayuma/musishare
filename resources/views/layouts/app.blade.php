<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('javascript')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                  <img src="{{ asset('images/logo.png') }}" class='navbar__logo'/>
                </a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                          <a class="nav-link" href="">MusiShareとは？</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link color-accent bold" href="/music/create">音楽を投稿</a>
                        </li>
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
                                    <a class="dropdown-item" href="/mypage">マイページ</a>
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

        <main class="">
          {{-- フラッシュメッセージのインポート --}}
            @include('layouts.flash-messages')
            @yield('content')
        </main>
        <footer class='footer p-2 p-lg-4'>
          <ul class='footer__list mb-0 pl-0 row'>
            <li class='d-none d-lg-block col-lg-1'></li>
            <li class='col-md-12 col-lg-2'><a class='w-100 d-block text-left text-lg-center text-white'>ホーム</a></li>
            <li class='col-md-12 col-lg-2'><a class='w-100 d-block text-left text-lg-center text-white'>MusiShareとは？</a></li>
            <li class='col-md-12 col-lg-2'><a class='w-100 d-block text-left text-lg-center text-white'>運営者情報</a></li>
            <li class='col-md-12 col-lg-2'><a class='w-100 d-block text-left text-lg-center text-white'>プライバシーポリシー</a></li>
            <li class='col-md-12 col-lg-2'><a class='w-100 d-block text-left text-lg-center text-white'>利用規約</a></li>
            <li class='d-none d-lg-block col-lg-1'></li>
          </ul> 
        </footer>
            @yield('footer')
    </div>
</body>
</html>
