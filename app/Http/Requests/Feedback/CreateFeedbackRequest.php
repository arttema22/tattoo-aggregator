<?php

namespace App\Http\Requests\Feedback;

use App\Http\Requests\BaseFormRequest;

class CreateFeedbackRequest extends BaseFormRequest
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
            'name'    => 'required|string|max:255',
            'phone'   => 'required_without:email|string|nullable|max:64',
            'email'   => 'required_without:phone|email|string|nullable|max:255',
            'message' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'    => 'Имя',
            'phone'   => 'Телефон',
            'email'   => 'E-mail',
            'message' => 'Сообщение',
        ];
    }
}