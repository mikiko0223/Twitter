<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Twitter</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
    <script src="{{asset('js/app.js')}}"></script>
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Twitter') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <div class="wrapper">
        <form action="/timeline" method="post">
            @csrf
            <div class="post-box">
                <input type="text" name="tweet" 
                placeholder="今なにしてる？">
                <button type="submit"
                class="submit-btn">ツイート</button>
            </div>
        </form>
        <div class="tweet-wrapper"></div>
        @foreach ($tweets as $tweet)
        <div class="tweet-box">
          <a href="{{ route('show',[$tweet->user->id]) }}"><img src="{{ asset('storage/images/'.$tweet->user->avatar) }}" alt=""></a>
            <div>{{ $tweet->tweet }}</div>
            <div class="destroy-btn">
                @if($tweet->user_id ==Auth::user()->id)
                <form action="{{ route('destroy',[$tweet->id]) }}" method="post">
                    @csrf
                    <input type="submit" value="削除">
                    
                </form>
                @endif
            </div>
        </div>
        <div style="padding:10px 40px">
            @if($tweet->likedBy(Auth::user())->count()>0)
            <a href="/likes/{{ $tweet->likedBy(Auth::user())->firstOrfail()->id }}"><i class="fas fa-heart-broken"></i></a>
            @else
            <a href="/tweets/{{ $tweet->id }}/likes"><i class="far fa-heart"></i></a>
            @endif
            {{ $tweet->likes->count() }}
        </div>
        @endforeach
       {{ $tweets->links() }}
    </div>
</body>
</html>