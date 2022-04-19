<?php

namespace App\Http\Requests;

class UpdateReservationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $max = 'max:255';

        return [
            'name' => ['required', 'string', $max],
            'last_name' => ['required', 'string', $max],
            'amount' => ['nullable', 'integer', 'min:1'],
            'email' => ['nullable', 'string', 'email', $max],
            'phone' => ['nullable', 'string', $max],
        ];
    }
}
