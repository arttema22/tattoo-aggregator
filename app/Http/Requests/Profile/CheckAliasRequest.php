<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;

class CheckAliasRequest extends BaseFormRequest
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
            'alias' => 'string|max:255'
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'alias' => 'Псевдоним салона для url',
        ];
    }
}