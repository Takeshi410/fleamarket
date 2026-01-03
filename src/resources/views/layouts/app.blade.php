<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <title>コーチテック</title>
    @yield('css')
</head>

<body>

<header class="header">
    <div class="header__inner">
        <a href="/">
            <img src="{{ asset('img/default/logo.png') }}" alt="">
        </a>
        @if (request()->is('/','search'))
        <form action="/search" method="get" class="header__inner__form">
            @csrf
            <input type="text" name="keyword" class="header__inner__form--search" value="{{ request('keyword') }}" placeholder="なにをお探しですか？">
            @if (request('tab') === 'mylist')
                <input type="hidden" name="tab" value="mylist">
            @endif
        </form>
        <nav class="header__inner__nav">
            @if (Auth::check())
                <form action="/logout" method="post">
                    @csrf
                <li><button class="header__inner__nav__item">ログアウト</button></li>
                </form>
                <li><a class="header__inner__nav__item" href="/mypage">マイページ</a></li>
                <li><button class="header__inner__nav__button">出品</button></li>
            @else
                <li><a class="header__inner__nav__item" href="/login">ログイン</a></li>
                <li><a class="header__inner__nav__item" href="/login">マイページ</a></li>
                <li><button class="header__inner__nav__button">出品</button></li>
            @endif
        </nav>
        @endif
        @yield('header')
    </div>
</header>

<main>
@yield('content')
</main>

</body>

</html>