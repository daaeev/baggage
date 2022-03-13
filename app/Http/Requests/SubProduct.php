<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubProduct extends FormRequest
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
            'slug' => [
                'required',
                'exists:\App\Models\Bag,slug',
                'countIsZero:\App\Models\Bag,count',
            ],
        ];
    }
}
