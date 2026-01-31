@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="login-content">
    <div class="login-content__inner">
        <h1>ログイン</h1>
        <form action="/login" method="post">
            @csrf
            <label for="email">メールアドレス</label>
            <span class="error-massage">
                @error('email')
                    {{ $message }}
                @enderror
            </span>
            <input type="text" name="email">
            <label for="password">パスワード</label>
            <span class="error-massage">
                @error('password')
                    {{ $message }}
                @enderror
            </span>
            <input type="password" name="password">
            <button class="login-form__button" type="submit">ログイン</button>
            <div class="login-content__inner__register">
                <a href="/register">会員登録はこちら</a>
            </div>
        </form>
    </div>
</div>
@endsection