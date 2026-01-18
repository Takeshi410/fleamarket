@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

    <div class="content">
        <div class="content__left">
            <div class="content__left__thumb">
                
            </div>
        </div>
    </div>
    {{ $product['product_name']}}
    {{ $product['brand']}}

@endsection