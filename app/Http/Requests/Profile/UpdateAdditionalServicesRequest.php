<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;

class UpdateAdditionalServicesRequest extends BaseFormRequest
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
            'additionalServices.*.id'    => 'present|integer',
            'additionalServices.*.as_id' => 'integer',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'additionalServices.*.as_id' => 'Идентификатор доп. услуги',
        ];
    }
}