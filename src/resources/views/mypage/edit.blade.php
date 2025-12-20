@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-content">
        <div class="profile-content__inner">
            <h2>プロフィール設定</h2>
            <form action="/register" method="post">
                <div class="profile-content__inner__avatar">
                    <img class="profile-content__inner__avatar--img" id="preview" alt="プレビュー">
                    <button type="button" id="select-file">画像を選択</button>
                    <input type="file" id="file-input" accept="image/*" style="display:none;">
                </div>
                <label for="username">ユーザー名</label>
                <input type="text" name="username">
                <label for="postcode">郵便番号</label>
                <input type="text" name="postcode">
                <label for="address">住所</label>
                <input type="text" name="address">
                <label for="building">建物名</label>
                <input type="text" name="building">
                <button class="profile-form__button" type="submit">更新する</button>

            </form>
        </div>

    </form>
</div>

<script>
const selectBtn = document.getElementById('select-file');
const fileInput = document.getElementById('file-input');
const preview = document.getElementById('preview');

selectBtn.addEventListener('click', () => {
    fileInput.click();
});

fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    return;

  // 画像以外を除外
    if (!file.type.startsWith('image/')) {
    alert('画像ファイルを選択してください');
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