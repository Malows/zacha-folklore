<?php

namespace App\Http\Requests;

class UpdateMenuItemRequest extends BaseRequest
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
            'price' => ['required', 'numeric'],
            'menu_section_id' => ['required', 'integer', 'exists:menu_sections,id'],
        ];
    }
}
