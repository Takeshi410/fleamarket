@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchases/purchase.css') }}">
@endsection

@section('content')

<div class="content">
    <div class="content__left">
        <div class="content__left__product">
            <div class="content__left__product__thumb">
                <img src="{{ asset('storage/images/' . $product['image_path']) }}" alt="{{ $product['image_path'] }}">
            </div>
            <div class="content__left__product__info">
                <h2>{{ $product['product_name']}}</h2>
                <p>¥&nbsp;{{ $product['price'] }}</p>
            </div>
        </div>

        <div class="content__left__payment">
            <h3>支払い方法</h3>
            <select class="content__left__payment__select" id="paymentSelect" required>
                <option value="" disabled selected>選択してください</option>
                <option value="konbini">コンビニ支払い</option>
                <option value="card">カード支払い</option>
            </select>
        </div>

        <div class="content__left__address">
            <div class="content__left__address__title">
                <h3>配送先</h3>
                <a href="{{ route('purchase.address', ['item_id' => $product->id]) }}">変更する</a>
            </div>
            <p>〒&nbsp;{{ substr($addressData['postcode'], 0, 3) . '-' . substr($addressData['postcode'], 3) }}</p>
            <p>{{ $addressData['address'] . ' ' . $addressData['building'] }}</p>
        </div>
    </div>

    <div class="content__right">
            <table class="content__right__table">
                <tr>
                    <th>商品代金</th>
                    <td>¥&nbsp;{{ $product['price'] }}
                    </td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td><p id="selectedText"></p>
                    </td>
                </tr>
            </table>

        <form action="{{ route('purchase.checkout',  ['item_id' => $product->id]) }}" method="POST">
        @csrf
            <input type="hidden" name="amount" value="{{ (int) $product['price'] }}">
            <input type="hidden" name="payment_method" id="selectedValue">
            @error('payment_method')
                <span class="content__right__error">{{ $message }}</span>
            @enderror
            <button type="submit" class="content__right__button">購入する</button>
        </form>
    </div>
</div>

<!-- 支払い方法反映処理 -->
<script>
    const select = document.getElementById('paymentSelect');
    const output = document.getElementById('selectedText');
    const hidden = document.getElementById('selectedValue');

    select.addEventListener('change', () => {
        output.textContent = select.selectedOptions[0].text;
        hidden.value = select.value;
    });
</script>

@endsection