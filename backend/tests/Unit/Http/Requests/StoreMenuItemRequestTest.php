<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\StoreMenuItemRequest as Request;

class StoreMenuItemRequestTest extends BaseRequestTest
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

        $this->assertEquals(2, count($keys));
        $this->assertEquals(['name', 'price'], $keys);
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
        $this->assertEquals(['required', 'numeric'], $rules['price']);
    }
}
