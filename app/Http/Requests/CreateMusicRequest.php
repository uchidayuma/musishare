<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMusicRequest extends FormRequest
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
            'music.title' => 'required | min:4 | string',
            'music.description' => 'required | min:20 | string',
            'music.mp3' => 'required | mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav | max:20000',
            'music.image' => 'sometimes | image | max:3072',
        ];
    }

    public function attributes()
    {
        return [
            'music.title' => 'フレーズのタイトル',
            'music.description' => 'フレーズの説明文',
            'music.mp3' => 'mp3ファイル',
            'music.image' => 'イメージ画像',
        ];
    }
}
