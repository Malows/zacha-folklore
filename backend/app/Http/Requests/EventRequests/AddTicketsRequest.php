<?php

namespace App\Http\Requests\EventRequests;

use App\Http\Requests\BaseRequest;

class AddTicketsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'tickets' => ['required', 'integer', 'min:1'],
        ];
    }
}
