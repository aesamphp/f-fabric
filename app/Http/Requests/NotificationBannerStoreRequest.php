<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\NotificationBanner;

class NotificationBannerStoreRequest extends Request
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
            'enabled' => 'required',
            'text' => 'required|max: 45',
        ];
    }

    public function messages()
    {
        return [
            'text.required' => 'The banner content is required.',
            'text.max' => 'The banner content may not be greater than 45 characters.',
        ];
    }
}
