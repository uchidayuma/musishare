<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Hash;

class PasswordChangeRequest extends FormRequest
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
            'password' => ['required',function($attribute, $value, $fail){
              if(!Hash::check($value, Auth::user()->password)){
                  $fail('現在のパスワードが違います');
              }
            }],
            'new-password' => 'required | min:6 | same:new-password-confirm',
            'new-password-confirm' => 'required| min:6',
        ];
    }

    public function attributes()
    {
        return [
            'password' => '現在のパスワード',
            'new-password' => '新しいパスワード',
            'new-password-confirm' => '新しいパスワード確認',
        ];
    }
}
