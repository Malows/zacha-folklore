<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\UpdateMenuSectionRequest as Request;

class UpdateMenuSectionRequestTest extends BaseRequestTest
{
    protected $validator = Request::class;

    /**
     * Check the rules keys of the FormRequest.
     *
     * @return void
     */
    public function testRulesKeys()
    {
        $keys = (new $this->validator())->rules();
        $keys = array_keys($keys);
        sort($keys);

        $this->assertEquals(3, count($keys));
        $this->assertEquals(['event_id', 'name', 'order'], $keys);
    }

    /**
     * Check the rules of the FormRequest.
     *
     * @return void
     */
    public function testRulesValues()
    {
        $rules = (new $this->validator())->rules();

        $this->assertIsArray($rules);

        $this->assertEquals(['required', 'string', 'max:255'], $rules['name']);
        $this->assertEquals(['required', 'integer', 'min:0'], $rules['order']);
        $this->assertEquals(['required', 'integer', 'exists:events,id'], $rules['event_id']);
    }
}
