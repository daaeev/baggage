<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BagCreate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:\App\Models\Bag,name',
            'price' => 'numeric|required',
            'discount_price' => 'nullable|numeric',
            'count' => 'integer|required',
            'image' => 'required|file|image',
        ];
    }
}
