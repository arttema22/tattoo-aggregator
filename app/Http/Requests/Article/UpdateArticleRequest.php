<?php

namespace App\Http\Requests\Article;

use App\Http\Requests\BaseFormRequest;

class UpdateArticleRequest extends BaseFormRequest
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
            'title'       => 'required|string|max:255',
            'description' => 'present|string|nullable',
            'content'     => 'present|string|nullable',
            'alias'       => 'required|unique:articles|string|max:255'
        ];
    }
}
