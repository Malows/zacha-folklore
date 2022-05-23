<?php

namespace Tests\Unit\Http\Requests\EventRequests;

use App\Http\Requests\EventRequests\AddTicketsRequest as Request;
use Tests\Unit\Http\Requests\BaseRequestTest;

class AddTicketsRequestTest extends BaseRequestTest
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

        $this->assertEquals(1, count($keys));
        $this->assertEquals(['tickets'], $keys);
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

        $this->assertEquals(['required', 'integer', 'min:1'], $rules['tickets']);
    }
}
