<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'string',
            'email' => 'string',
            'first_name' => 'string',
            'last_name' => 'string',
            'position_held' => 'string',
            'status' => 'string',
        ];
    }
}
