@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header')
    <input type="text" class="header__inner__search">
    <nav class="header__inner__nav">
        @if (Auth::check())
            <form action="/logout" method="post">
                @csrf
            <li><button class="header__inner__button">ログアウト</button></li>
            </form>
            <li><a href="/mypage">マイページ</a></li>
            <li><button>出品</button></li>
        @else
            <li><a href="/login">ログイン</a></li>
            <li><a href="/login">マイページ</a></li>
            <li><button>出品</button></li>
        @endif
    </nav>
@endsection

@section('content')
<div class="content">
    <nav class="content__menu">
        <li class="content__menu__item">おすすめ<li>
        <li class="content__menu__item">マイリスト<li>
    </nav>

    <!-- 商品一覧 -->
    <div class="content__product">
        <div class="content__product__thumb">
            <img src="{{ asset('img/product/000001_1.jpg') }}" alt="">
            <p>時計</p>
        </div>
        <div class="content__product__thumb">
            <img src="{{ asset('img/product/000002_1.jpg') }}" alt="">
        </div>
        <div class="content__product__thumb">
            <img src="{{ asset('img/product/000003_1.jpg') }}" alt="">
        </div>
        <div class="content__product__thumb">
            <img src="{{ asset('img/product/000004_1.jpg') }}" alt="">
        </div>
        <div class="content__product__thumb">
            <img src="{{ asset('img/product/000005_1.jpg') }}" alt="">
        </div>
        <div class="content__product__thumb">
            <img src="{{ asset('img/product/000006_1.jpg') }}" alt="">
        </div>
    </div>

</div>
@endsection