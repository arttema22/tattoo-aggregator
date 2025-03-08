<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;

class UpdateContactRequest extends BaseFormRequest
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
            'country_id' => 'integer',
            'city'       => 'string',
            'metro_id'   => 'nullable|integer',
            'name'       => 'string|max:255',
            'address'    => 'nullable|string|max:255',
            'phone'      => 'nullable|string|max:255',
            'site'       => 'nullable|string|max:255',
            'email'      => 'nullable|email|string|max:255',
            'district'   => 'nullable|string|max:255',
            'lat'        => 'numeric',
            'lon'        => 'numeric',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'country_id' => 'Идентификатор страны',
            'city'       => 'Город',
            'metro_id'   => 'Идентификатор метро',
            'alias'      => 'Псевдоним салона для url',
            'name'       => 'Название',
            'address'    => 'Адрес',
            'phone'      => 'Телефон',
            'site'       => 'Сайт',
            'email'      => 'E-mail',
            'district'   => 'Район',
            'lat'        => 'Широта',
            'lon'        => 'Долгота',
        ];
    }
}
