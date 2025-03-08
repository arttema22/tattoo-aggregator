<?php

namespace App\Http\Requests\Search;

use App\Http\Requests\BaseFormRequest;

class SearchTatuajeRequest extends BaseFormRequest
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
            'place'   => 'array',
            'place.*' => 'string',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'place' => 'Место',
        ];
    }
}
