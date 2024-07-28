<?php

namespace App\Http\Requests\Categories;

use App\Http\Requests\ApiRequest;

class UpdateCategoryRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'bail|required',
            'slug' => 'bail|required|unique:categories,slug,' . $this->id,
            'desc' => 'nullable',
            'active' => 'bail|required',
            'parent_id' => 'nullable'
        ];
    }
}
