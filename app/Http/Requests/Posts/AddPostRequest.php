<?php

namespace App\Http\Requests\Posts;

use App\Http\Requests\ApiRequest;
use Illuminate\Support\Facades\Validator;

class AddPostRequest extends ApiRequest
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
        Validator::extend('not_contains', function ($attribute, $value, $parameters) {
            return !str_contains($value, $parameters[0]);
        });

        return [
            'title' => 'bail|required',
            'slug' => 'bail|required|unique:posts',
            'source' => 'nullable',
            'desc' => 'nullable',
            'content' => 'bail|required',
            'image' => 'bail|required',
            'active' => 'bail|required',
            'is_hot' => 'bail|required',
            'publish_date' => 'nullable',
            'categories_id' => 'required|string|not_contains:[]'
        ];
    }

    public function messages(): array
    {
        return [
            'categories_id.not_contains' => 'Category field is required.'
        ];
    }
}
