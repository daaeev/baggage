<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserSetRole extends FormRequest
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
        // перечень значений статусов пользователя для валидатора 'in'
        $stringOfUserStatuses = User::STATUS_ADMIN . ',' . User::STATUS_USER . ',' . User::STATUS_BANNED;

        return [
            'id' => 'bail|required|integer|exists:\App\Models\User,id',
            'role' => 'bail|required|integer|in:' . $stringOfUserStatuses,
        ];
    }
}
