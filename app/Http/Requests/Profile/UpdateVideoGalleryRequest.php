<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;

class UpdateVideoGalleryRequest extends BaseFormRequest
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
            'url' => 'required|url'
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'url' => 'Ссылка на видео'
        ];
    }
}
