<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_image' => 'required|image|max:1024',
            'product_name' => 'required|string|max:50',
            'brand' => 'required|string|max:20',
            'description' => 'required|string|max:500',
            'condition' => 'required',
            'price' => 'required|regex:/^\d+$/',
            'categories' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'product_image.required' => '商品画像が選択されていません',
            'product_image.image' => '画像ファイルを選択してください',
            'product_image.max' => '画像サイズは1MB以下にしてください',
            'product_name.required' => '商品名を入力してください',
            'product_name.max' => '商品名は50文字以内で入力してください',
            'brand.required' => 'ブランド名を入力してください',
            'brand.max' => 'ブランド名は20文字以内で入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明は500文字以内で入力してください',
            'condition.required' => 'コンディションを選択してください',
            'price.required' => '販売価格を入力してください',
            'price.regex' => '販売価格は半角数字のみで入力してください',
            'categories.required' => 'カテゴリーを選択してください',
        ];
    }
}
