<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'user.name' => 'required | string | max:25',
            'user.description' => 'sometimes | string | nullable | max:1000',
            'user.image' => 'sometimes | image | max:3072',
        ];
    }

    public function attributes()
    {
        return [
            'user.name' => 'ユーザー名',
            'user.description' => '自己紹介',
            'user.image' => 'プロフィール画像',
        ];
    }
}
