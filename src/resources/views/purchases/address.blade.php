@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchases/address.css') }}">
@endsection

@section('content')
<div class="content">
    <h2>住所の変更</h2>

    <form action="{{ route('purchase.address.update', ['item_id' => $item_id]) }}" method="post">
        @method('PATCH')
        @csrf
        <label for="postcode">郵便番号</label>
        @error('postcode')
            <span class="content__error">{{ $message }}</span>
        @enderror
        <input type="text" name="postcode" value="{{ old('postcode', $addressData['postcode']) }}">

        <label for="address">住所</label>
        @error('address')
            <span class="content__error">{{ $message }}</span>
        @enderror
        <input type="text" name="address" value="{{ old('address', $addressData['address']) }}">

        <label for="building">建物名</label>
        @error('building')
            <span class="content__error">{{ $message }}</span>
        @enderror
        <input type="text" name="building" value="{{ old('building', $addressData['building']) }}">

        <button class="content__button" type="submit">更新する</button>
    </form>
</div>
@endsection