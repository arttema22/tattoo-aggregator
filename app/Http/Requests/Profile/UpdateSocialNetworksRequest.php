<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;

class UpdateSocialNetworksRequest extends BaseFormRequest
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
            'socialNetworks.*.id'    => 'present|integer',
            'socialNetworks.*.sn_id' => 'required|integer',
            'socialNetworks.*.value' => 'present|nullable|string',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'socialNetworks.*.sn_id' => 'Тип соц. сети',
            'socialNetworks.*.value' => 'Аккаунт соц. сети',
        ];
    }
}