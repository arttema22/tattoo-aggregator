<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;

class CreateWorkFileRequest extends BaseFormRequest
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
            'work'            => 'required|dimensions:min_width=250,min_height=250|max:10240',
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
            'work'            => 'Фото работы',
            'name'            => 'Название работы',
            'description'     => 'Описание работы',
            'attribute'       => 'Теги',
            'is_adult'        => 'Взрослый контент',
            'is_downloadable' => 'Разрешить скачивание',
        ];
    }
}