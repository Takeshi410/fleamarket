@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="content">
    <nav class="content__menu">
        <li class="{{ $tab === 'recommend' ? 'content__menu__item--active' : 'content__menu__item'}}"><a href="/">おすすめ</a><li>
        <li class="{{ $tab === 'mylist' ? 'content__menu__item--active' : 'content__menu__item'}}"><a href="/?tab=mylist">マイリスト</a><li>
    </nav>

    <!-- 商品一覧 -->
    <div class="content__product">
        @foreach ($products as $product)
        <div class="content__product__thumb">
            <!-- <a href=""> -->
            <img src="{{ asset('storage/images/products/' . $product['file_name']) }}" alt="{{ $product['file_name'] }}">
            <!-- </a> -->
            <p class="content__product__thumb--p">{{ $product['product_name'] }}
                @if ($product['purchased_users_exists'])
                    <span class="content__product__thumb--span">sold</span>
                @endif
            </p>
        </div>
        @endforeach
    </div>

</div>
@endsection