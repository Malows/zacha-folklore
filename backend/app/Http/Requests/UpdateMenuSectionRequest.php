<?php

namespace App\Http\Requests;

class UpdateMenuSectionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer', 'min:0'],
            'event_id' => ['required', 'integer', 'exists:events,id'],
        ];
    }
}
