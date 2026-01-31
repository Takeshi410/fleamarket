@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content__left">
        <div class="content__left__photo">
            <img src="{{ asset('storage/images/' . $product['image_path']) }}" alt="{{ $product['image_path'] }}">
        </div>
    </div>

    <div class="content__right">
        <h1 class="content__right__title">{{ $product['product_name'] }}</h1>
        <p class="content__right__brand">{{ $product['brand'] }}</p>
        <p class="content__right__price"><span class="content__right__price--span">¥</span>{{ $product['price'] }}<span>&nbsp;(税込)</span></p>
        @php
            $isLiked = auth()->check() && $product->likedUsers->contains('id', auth()->id());
        @endphp
        <table class="content__right__table">
            <tr>
                <td>
                    <form action="{{ route('item.like.toggle', ['item_id' => $product->id]) }}" method="post">
                        @csrf
                        <button type="submit" class="content__right__table--button">
                            <img src="{{ asset($isLiked ? 'img/default/heart_on.png' : 'img/default/heart_off.png') }}" alt="いいね">
                        </button>
                    </form>
                </td>
                <td><img src="{{ asset('img/default/speech_bubble.png') }}" alt="コメント"></td>
            </tr>
            <tr>
                <td>{{ $product->likes_count }}</td>
                <td>{{ $product->comments_count }}</td>
            </tr>
        </table>
        @if ($product['purchased_users_exists'])
        <p class="content__right__button--sold">売り切れ</p>
        @else
        <form action="{{ route('purchase.index', ['item_id' => $product->id]) }}" method="get">
            @csrf
            <p><button class="content__right__button">購入手続きへ</button></p>
        </form>
        @endif
        <h2>商品説明</h2>
        <p class="content__right__description">{{ $product['description'] }}</p>
        <h2>商品の情報</h2>

        <div class="content__right__category">
            <h3>カテゴリー</h3>
            <div class="content__right__category--list">
                @foreach($product->categories as $category)
                    <div class="content__right__category--tag">{{ $category->category }}</div>
                @endforeach
            </div>
        </div>

        <div class="content__right__condition">
            <h3>商品の状態</h3>
            <div class="content__right__condition--tag">{{ $product->condition->condition }}</div>
        </div>

        <p class="content__right__comment">コメント({{ $product->comments->count() }})</p>

        @foreach($product->comments as $comment)
            <div class="content__right__user">
                <div class="content__right__user--avatar">
                    <img src="{{ asset('storage/images/' . $comment->user->avatar_path) }}" alt="" onerror="this.style.display='none'">
                </div>
                <p class="content__right__user--name">{{ $comment->user->username ?? 'Unknown' }}</p>
            </div>
            <p  class="content__right__text">{!! nl2br(e($comment->comment)) !!}</p>
        @endforeach

        <h3>商品へのコメント</h3>
        <form action="{{ route('item.comment.store', ['item_id' => $product->id]) }}" method="post">
            @csrf
            <textarea class="content__right__textarea" name="comment">{{ old('comment') }}</textarea>

            @error('comment')
                <p class="content__right__error">{{ $message }}</p>
            @enderror
            <p><button class="content__right__button" type="submit">コメントを送信する</button></p>
        </form>


    </div>


</div>

@endsection
