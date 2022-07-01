<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\User;
use App\Models\UserGroup;

class AdminResetPasswordRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return User::whereEmail($this->input('email'))
            ->firstOrFail()
            ->hasGroup(UserGroup::GROUP_ADMIN);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }
}
