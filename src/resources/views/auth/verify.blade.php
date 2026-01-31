@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify.css') }}">
@endsection

@section('content')
    <div class="content">
        <p class="content__p">
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください。
        </p>

        <button onclick="location.href='http://localhost:8025/#'" class="content__verify">認証はこちらから</button>

        @if (session('status') == 'verification-link-sent')
            <p class="content__resend--message">
                認証メールを送信しました
            </p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="content__resend">
                認証メールを再送する
            </button>
        </form>
    </div>
@endsection