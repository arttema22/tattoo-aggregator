<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;
use App\Rules\MatchCurrentPassword;

class ChangeUserPasswordRequest extends BaseFormRequest
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
            'current_password'     => [
                'required',
                'string',
                new MatchCurrentPassword
            ],
            'password'         => 'required|string|min:8',
            'password_confirm' => 'required|same:password'
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'current_password' => 'Текущий пароль',
            'password'         => 'Новый пароль',
            'password_confirm' => 'Подтверждение нового пароля'
        ];
    }
}