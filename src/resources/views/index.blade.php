@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="content">
    <nav class="content__menu">
        <ul>
            <li class="{{ $tab === 'recommend' ? 'content__menu__item--active' : 'content__menu__item'}}"><a href="{{ request('keyword') ? url('/search').'?'.http_build_query(['keyword' => request('keyword')]) : url('/') }}">おすすめ</a></li>
            <li class="{{ $tab === 'mylist' ? 'content__menu__item--active' : 'content__menu__item'}}"><a href="{{ request('keyword') ? url('/search').'?'.http_build_query(['keyword' => request('keyword')]).'&tab=mylist' : url('/?tab=mylist') }}">マイリスト</a></li>
        </ul>
    </nav>

    <!-- 商品一覧 -->
    <div class="content__product">
        @foreach ($products as $product)
        <div class="content__product__thumb">
            <div class="content__product__thumb__image">
            <a href="{{ route('item.detail', ['item_id' => $product['id']]) }}">
                    <img src="{{ asset('storage/images/' . $product['image_path']) }}" alt="{{ $product['image_path'] }}">
            </a>
            </div>
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