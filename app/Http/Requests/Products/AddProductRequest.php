<?php

namespace App\Http\Requests\Products;

use App\Http\Requests\ApiRequest;

class AddProductRequest extends ApiRequest
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
            'name' => 'required|string',
            'des' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'bg_img' => 'bail|required',
            'details_img' => 'bail|required',
            'status' => 'nullable|integer',
            'created_by' => 'exists:users,id',
        ];
    }
}
