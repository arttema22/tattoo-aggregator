<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;

class UpdateWorkFileRequest extends BaseFormRequest
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
            'name'            => 'required|string',
            'description'     => 'nullable|string',
            'attribute'       => 'array',
            'attribute.*'     => 'integer',
            'is_adult'        => 'boolean',
            'is_downloadable' => 'boolean',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'name'            => 'Название работы',
            'description'     => 'Описание работы',
            'attribute'       => 'Теги',
            'is_adult'        => 'Взрослый контент',
            'is_downloadable' => 'Разрешить скачивание',
        ];
    }
}