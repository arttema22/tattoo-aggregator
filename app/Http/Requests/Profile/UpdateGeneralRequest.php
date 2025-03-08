<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;
use App\Rules\AliasUnique;

class UpdateGeneralRequest extends BaseFormRequest
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
            'name'        => 'required|string|max:255',
            'alias'       => [
                'string',
                'max:255',
                new AliasUnique( $this->get( 'alias' ), $this->route()?->parameter('contact_id') )
            ],
            'description' => 'nullable|string',
            'cover'       => 'nullable|max:10240'
            //'cover'       => 'present|nullable|dimensions:min_width=1024,min_height=256|max:10240'
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'name'        => 'Имя',
            'alias'       => 'Псевдоним салона для url',
            'description' => 'Описание',
            'cover'       => 'Фото обложки'
        ];
    }
}
