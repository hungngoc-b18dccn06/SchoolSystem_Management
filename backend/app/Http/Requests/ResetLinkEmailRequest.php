<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ResetLinkEmailRequest extends FormRequest
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
            'email' => 'required|string|exists:users,email'
        ];
    }

    public function data()
    {
        return [
            'email' => $this->get('email'),
            'token' => Str::random(60),
            'created_at' => now()
        ];
    }
    public function messages()
    {
        return [
            'email.exists' => 'このメールアドレスは登録されていません。'
        ];
    }
}
