<?php

namespace App\Http\Requests\Search;

use App\Http\Requests\BaseFormRequest;

class SearchPiercingRequest extends BaseFormRequest
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
            'gender'          => 'array',
            'gender.*'        => 'string',
            'place'           => 'array',
            'place.*'         => 'string',
            'healingPeriod'   => 'array',
            'healingPeriod.*' => 'integer',
            'painLevel'       => 'array',
            'painLevel.*'     => 'integer'
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'gender'        => 'Пол',
            'place'         => 'Место',
            'healingPeriod' => 'Время заживления',
            'painLevel'     => 'Уровень боли',
        ];
    }
}
