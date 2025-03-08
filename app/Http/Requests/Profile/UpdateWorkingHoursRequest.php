<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;

class UpdateWorkingHoursRequest extends BaseFormRequest
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
            'workingHours.*.id'          => 'integer',
            'workingHours.*.day'         => 'required|integer|min:1|max:7',
            'workingHours.*.start'       => 'present|nullable|numeric|min:0|max:24',
            'workingHours.*.end'         => 'present|nullable|numeric|min:0|max:24',
            'workingHours.*.is_weekend'  => 'boolean',
            'workingHours.*.is_nonstop'  => 'boolean'
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'workingHours.*.day'         => 'День',
            'workingHours.*.start'       => 'Открыто с',
            'workingHours.*.end'         => 'Открыто до',
            'workingHours.*.is_weekend'  => 'Выходной',
            'workingHours.*.is_nonstop'  => 'Круглосуточно'
        ];
    }
}