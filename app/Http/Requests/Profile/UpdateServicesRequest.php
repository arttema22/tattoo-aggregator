<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;

class UpdateServicesRequest extends BaseFormRequest
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
            'services.*.id'             => 'integer',
            'services.*.type'           => 'required|integer',
            'services.*.name'           => 'required|string|max:255',
            'services.*.price'          => 'required|numeric',
            'services.*.currency'       => 'string|max:3',
            'services.*.is_start_price' => 'boolean',
            'services.*.status'         => 'boolean',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'services.*.type'           => 'Тип',
            'services.*.name'           => 'Название',
            'services.*.price'          => 'Цена',
            'services.*.currency'       => 'Валюта',
            'services.*.is_start_price' => 'Цена от',
            'services.*.status'         => 'Статус',
        ];
    }
}