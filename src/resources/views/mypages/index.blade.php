@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypages/index.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content__user">
        <div class="content__user__avatar">
            <img src="{{ asset('storage/' . $user['avatar_path']) }}" alt="">
        </div>
        <p class="content__user__name">{{ $user['username'] }}</p>
        <form class="content__user__form" action="{{ route('mypage.profile') }}" method="get">
            <button class="content__user__form--button">プロフィールを編集</button>
        </form>
    </div>
    <nav class="content__menu">
        <li><a class="{{ $page === 'sell' ? 'content__menu__item--active' : 'content__menu__item'}}" href="{{ route('mypage.index', ['page' => 'sell']) }}">出品した商品</a><li>
        <li><a class="{{ $page === 'buy' ? 'content__menu__item--active' : 'content__menu__item'}}" href="{{ route('mypage.index', ['page' => 'buy']) }}">購入した商品</a><li>
    </nav>

    <!-- 出品一覧 -->
    <div class="content__mypage">
        @if ($page === 'sell')
            @foreach ($sellProducts as $product)
            <div class="content__mypage__thumb">
                <a href="{{ route('item.detail', ['item_id' => $product['id']]) }}">
                    <img src="{{ asset('storage/images/products/' . $product['file_name']) }}" alt="{{ $product['file_name'] }}">
                </a>
                <p class="content__mypage__thumb--p">{{ $product['product_name'] }}
                    @if ($product['purchased_users_exists'])
                        <span class="content__mypage__thumb--span">sold</span>
                    @endif
                </p>
            </div>
            @endforeach
        @elseif ($page === 'buy')
            @foreach ($buyProducts as $product)
            <div class="content__mypage__thumb">
                <a href="">
                    <img src="{{ asset('storage/images/products/' . $product['file_name']) }}" alt="{{ $product['file_name'] }}">
                </a>
                <p class="content__mypage__thumb--p">{{ $product['product_name'] }}
                    @if ($product['purchased_users_exists'])
                        <span class="content__mypage__thumb--span">sold</span>
                    @endif
                </p>
            </div>
            @endforeach
        @endif
    </div>

</div>
@endsection