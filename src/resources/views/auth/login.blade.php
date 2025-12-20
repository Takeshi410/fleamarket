@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-content">
        <div class="login-content__inner">
            <h2>ログイン</h2>
            <form action="/login" method="post">
                @csrf
                <label for="email">メールアドレス</label>
                <span>
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>
                <input type="text" name="email">
                <label for="password">パスワード</label>
                <span>
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

    </form>
</div>
@endsection