<?php

namespace App\Http\Requests\Search;

use App\Http\Requests\BaseFormRequest;

class SearchTattooRequest extends BaseFormRequest
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
            'gender'       => 'array',
            'gender.*'     => 'string',
            'place'        => 'array',
            'place.*'      => 'string',
            'style'        => 'array',
            'style.*'      => 'string',
            'size'         => 'array',
            'size.*'       => 'string',
            'tempType'     => 'array',
            'tempType.*'   => 'string',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'gender'   => 'Пол',
            'place'    => 'Место',
            'style'    => 'Стиль',
            'size'     => 'Размер',
            'tempType' => 'Тип',
        ];
    }
}
