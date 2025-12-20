@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-content">
        <div class="register-content__inner">
            <h2>会員登録</h2>
            <form action="/register" method="post">
                @csrf
                <label for="username">ユーザー名</label>
                <span>
                    @error('username')
                        {{ $message }}
                    @enderror
                </span>
                <input type="text" name="username" value="{{ old('username') }}" />
                <label for="email">メールアドレス</label>
                <span>
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>
                <input type="text" name="email" value="{{ old('email') }}" />
                <label for="password">パスワード</label>
                <span>
                    @error('password')
                        {{ $message }}
                    @enderror
                </span>
                <input type="password" name="password" />
                <label for="password_confirmation">確認用パスワード</label>
                <input type="password" name="password_confirmation" />
                <button class="register-form__button" type="submit">登録</button>
            </form>
                <div class="register-content__inner__register">
                    <a href="/login">ログインはこちら</a>
                </div>
        </div>
</div>
@endsection