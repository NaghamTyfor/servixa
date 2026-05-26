<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_account_id' => ['required', 'exists:business_accounts,id'],
            'needed_time'         => ['nullable', 'date', 'after:now'],
            'details'             => ['nullable', 'string', 'max:1000'],
            'quantity'            => ['nullable', 'integer', 'min:1'],
        ];
    }
}
