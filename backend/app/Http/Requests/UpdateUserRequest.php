<?php

namespace App\Http\Requests;

use App\Enums\Role;
use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => [
                Rule::unique('users')->ignore($this->id),
                'nullable',
                'email',
                'max:100',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => 'nullable|string|regex:/^[a-zA-Z0-9!@#$%^&*()_]{8,16}$/',
            'role' => 'nullable|in:' . implode(",", Role::asArray()),
            'status' => 'nullable|in:' . implode(",", Status::asArray()),
            'avatar' => 'file|nullable|mimes:jpeg,jpg,png,gif|max:2048'
        ];
    }

    public function data()
    {
        $data = [];
        if ($this->has('first_name')) {
            $data['first_name'] = $this->first_name;
        }
        if ($this->has('last_name')) {
            $data['last_name'] = $this->last_name;
        }
        if ($this->has('email')) {
            $data['email'] = $this->email;
        }
        if ($this->has('password')) {
            $data['password'] = bcrypt($this->password);
        }
        if ($this->has('role')) {
            $data['role'] = $this->role;
        }
        if ($this->has('status')) {
            $data['status'] = $this->status;
        }if ($this->has('avatar')) {
            $data['avatar'] = $this->file('avatar');
        }

        return $data;
    }

    public function messages()
    {
        return [
            'email.regex' => 'メール形式が正しくありません。'
        ];
    }
}
