<?php

namespace App\Http\Requests\EventRequests;

use App\Http\Requests\BaseRequest;

class CopyMenuRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'from' => ['required', 'integer', 'exists:events,id'],
            'to' => ['required', 'integer', 'exists:events,id'],
        ];
    }
}
