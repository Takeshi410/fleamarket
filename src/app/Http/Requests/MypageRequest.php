<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MypageRequest extends FormRequest
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
            'username' => 'nullable|string|max:20',
            'postcode' => 'nullable|string|min:7|max:7',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:1028',
        ];
    }

    public function messages()
    {
        return [
            'username.max' => 'ユーザー名は20文字以内で入力してください',
            'postcode.max' => '郵便番号は7桁で入力してください',
            'postcode.min' => '郵便番号は7桁で入力してください',
            'address.max' => '住所は255文字以内で入力してください',
            'building.max' => '建物名は255文字以内で入力してください',
            'avatar.max' => '画像サイズは1MB以下にしてください',
        ];
    }
}
