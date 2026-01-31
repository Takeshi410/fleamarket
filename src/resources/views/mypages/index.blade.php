@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypages/index.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content__user">
        <div class="content__user__avatar">
            <img src="{{ asset('storage/images/' . $user['avatar_path']) }}" alt="">
        </div>
        <p class="content__user__name">{{ $user['username'] }}</p>
        <div class="content__user__edit">
        <a href="{{ route('mypage.profile', ['from' => 'mypage']) }}">プロフィールを編集</a>
        </div>
    </div>
    <nav class="content__menu">
        <ul>
            <li><a class="{{ $page === 'sell' ? 'content__menu__item--active' : 'content__menu__item'}}" href="{{ route('mypage.index', ['page' => 'sell']) }}">出品した商品</a></li>
            <li><a class="{{ $page === 'buy' ? 'content__menu__item--active' : 'content__menu__item'}}" href="{{ route('mypage.index', ['page' => 'buy']) }}">購入した商品</a></li>
        </ul>
    </nav>

    <!-- 出品一覧 -->
    <div class="content__mypage">
        @if ($page === 'sell')
            @foreach ($sellProducts as $product)
            <div class="content__mypage__thumb">
                <div class="content__mypage__thumb__image">
                    <a href="{{ route('item.detail', ['item_id' => $product['id']]) }}">
                        <img src="{{ asset('storage/images/' . $product['image_path']) }}" alt="{{ $product['image_path'] }}">
                    </a>
                </div>
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
                <div class="content__mypage__thumb__image">
                    <a href="{{ route('item.detail', ['item_id' => $product['id']]) }}">
                        <img src="{{ asset('storage/images/' . $product['image_path']) }}" alt="{{ $product['image_path'] }}">
                    </a>
                </div>
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