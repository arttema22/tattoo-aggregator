<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rules;

class ResetPasswordRequest extends BaseFormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'token'    => 'required',
            'email'    => 'required|email|max:255|exists:users',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                Rules\Password::defaults()
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'token'    => 'Токен',
            'email'    => 'Электронная почта',
            'password' => 'Пароль',
        ];
    }
}