@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="content">
    <h1>商品の出品</h1>
    <form action="/sell" method="post" enctype="multipart/form-data">
        @csrf
        <label class="content__label" for="product_image">商品画像</label>
        @error('product_image')
            <span class="content__error">{{ $message }}</span>
        @enderror
        <div class="content__image">
            <div class="content__image__preview" id="preview-container" style="display: none;">
                <img class="content__image--img" id="preview" alt="preview">
                <button class="content__image__delete" type="button" id="delete-preview">×</button>
            </div>
            <button class="content__image__button" type="button" id="select-file">画像を選択する</button>
            <input type="file" name="product_image" id="file-input" accept="image/*" style="display:none;">
        </div>

        <h2>商品の詳細</h2>
        <label  class="content__label" for="categories">カテゴリー</label>
        @error('categories')
            <span class="content__error">{{ $message }}</span>
        @enderror
        <div class="content__category">
            @foreach ($categories as $category)
            <label><input type="checkbox" name="categories[]" value="{{ $category['id'] }}" {{ in_array($category['id'], old('categories', [])) ? 'checked' : '' }}><span>{{ $category['category'] }}</span></label>
            @endforeach
        </div>

        <label class="content__label">商品の状態</label>
        @error('condition')
            <span class="content__error">{{ $message }}</span>
        @enderror
        <select name="condition" id="" class="content__condition">
            <option value="" disabled {{ old('condition') ? '' : 'selected' }}>選択してください</option>
            @foreach ($conditions as $condition)
            <option value="{{ $condition['id'] }}" {{ old('condition') === $condition['id'] ? 'selected' : '' }}>{{ $condition['condition'] }}</option>
            @endforeach
        </select>

        <h2>商品名と説明</h2>

        <label  class="content__label" for="product_name">商品名</label>
        @error('product_name')
            <span class="content__error">{{ $message }}</span>
        @enderror
        <input type="text" name="product_name" value="{{ old('product_name') }}">

        <label  class="content__label" for="brand">ブランド名</label>
        @error('brand')
            <span class="content__error">{{ $message }}</span>
        @enderror
        <input type="text" name="brand" value="{{ old('brand') }}">

        <label  class="content__label" for="description">商品の説明</label>
        @error('description')
            <span class="content__error">{{ $message }}</span>
        @enderror
        <textarea name="description">{{ old('description') }}</textarea>

        <label  class="content__label" for="price">販売価格</label>
        @error('price')
            <span class="content__error">{{ $message }}</span>
        @enderror
        <div class="content__price">
            <input type="text" name="price" value="{{ old('price') }}">
        </div>
        <button class="content__button" type="submit">出品する</button>
    </form>
</div>


<!-- 画像選択時のプレビュー表示スクリプト -->
<script>
const selectBtn = document.getElementById('select-file');
const fileInput = document.getElementById('file-input');
const preview = document.getElementById('preview');
const previewContainer = document.getElementById('preview-container');
const deleteBtn = document.getElementById('delete-preview');

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
    const maxMB = 3; // 上限MB
    const maxBytes = maxMB * 1024 * 1024;

    if (file.size > maxBytes) {
        alert(`${maxMB}MB以下の画像を選択してください`);
        fileInput.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        preview.src = e.target.result;
        previewContainer.style.display = 'block';
        selectBtn.style.display = 'none';
    };
    reader.readAsDataURL(file);
});

// 画像プレビューの削除ボタン
deleteBtn.addEventListener('click', () => {
    preview.src = '';
    fileInput.value = '';
    previewContainer.style.display = 'none';
    selectBtn.style.display = 'inline-block';
});
</script>
@endsection
