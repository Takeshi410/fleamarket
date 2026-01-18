@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypages/profile.css') }}">
@endsection

@section('content')
<div class="content">
        <div class="content__inner">
            <h2>プロフィール設定</h2>
            <form action="{{ route('mypage.profile') }}" method="post" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="content__inner__avatar">
                    <img src="{{ asset('storage/' . $user['avatar_path']) }}" class="content__inner__avatar--img" id="preview" alt="preview">
                    <button class="content__inner__avatar--button" type="button" id="select-file">画像を選択する</button>
                    <input type="file" name="avatar" id="file-input" accept="image/*" style="display:none;">
                </div>
                <label for="username">ユーザー名</label>
                @error('username')
                    <span class="content__inner__error">{{ $message }}</span>
                @enderror
                <input type="text" name="username" value="{{ old('username', $user['username']) }}">

                <label for="postcode">郵便番号</label>
                @error('postcode')
                    <span class="content__inner__error">{{ $message }}</span>
                @enderror
                <input type="text" name="postcode" value="{{ old('postcode', $user['postcode']) }}">

                <label for="address">住所</label>
                @error('address')
                    <span class="content__inner__error">{{ $message }}</span>
                @enderror
                <input type="text" name="address" value="{{ old('address', $user['address']) }}">

                <label for="building">建物名</label>
                @error('building')
                    <span class="content__inner__error">{{ $message }}</span>
                @enderror
                <input type="text" name="building" value="{{ old('building', $user['building']) }}">

                <button class="content__inner__button" type="submit">更新する</button>
            </form>
        </div>
</div>


<!-- 画像選択時のプレビュー表示スクリプト -->
<script>
const selectBtn = document.getElementById('select-file');
const fileInput = document.getElementById('file-input');
const preview = document.getElementById('preview');

selectBtn.addEventListener('click', () => {
    fileInput.click();
});

fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if (!file) return;

    // 画像以外を除外
    if (!file.type.startsWith('image/')) {
    alert('画像ファイルを選択してください');
    fileInput.value = '';
    return;
    }

    // 最大容量の設定
    const maxMB = 1; // 上限MB
    const maxBytes = maxMB * 1024 * 1024;

    if (file.size > maxBytes) {
    alert(`${maxMB}MB以下の画像を選択してください`);
    fileInput.value = '';
    return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
    preview.src = e.target.result;
    preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
});
</script>
@endsection
