<?php

namespace Tests\Unit\Http\Requests\EventRequests;

use App\Http\Requests\EventRequests\StoreRequest as Request;
use Tests\Unit\Http\Requests\BaseRequestTest;

class StoreRequestTest extends BaseRequestTest
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
        $this->assertEquals(['event_day'], $keys);
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

        $this->assertEquals(['required', 'date'], $rules['event_day']);
    }
}
