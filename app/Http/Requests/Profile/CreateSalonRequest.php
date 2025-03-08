<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;

class CreateSalonRequest extends BaseFormRequest
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
            'name' => 'required|string'
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'name' => 'Название'
        ];
    }
}