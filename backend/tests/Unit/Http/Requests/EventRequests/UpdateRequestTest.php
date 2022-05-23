<?php

namespace Tests\Unit\Http\Requests\EventRequests;

use App\Http\Requests\EventRequests\UpdateRequest as Request;
use Tests\Unit\Http\Requests\EventRequests\BaseRequestTest;

class UpdateRequestTest extends BaseRequestTest
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
        $this->assertEquals(['event_day', 'is_active', 'started_at'], $keys);
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
        $this->assertEquals(['nullable', 'date'], $rules['started_at']);
        $this->assertEquals(['nullable', 'boolean'], $rules['is_active']);
    }
}
