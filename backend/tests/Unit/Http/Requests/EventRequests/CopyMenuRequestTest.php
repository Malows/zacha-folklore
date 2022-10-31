<?php

namespace Tests\Unit\Http\Requests\EventRequests;

use App\Http\Requests\EventRequests\CopyMenuRequest as Request;
use Tests\Unit\Http\Requests\BaseRequestTest;

class CopyMenuRequestTest extends BaseRequestTest
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
        $this->assertEquals(['from', 'to'], $keys);
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

        $this->assertEquals(['required', 'integer', 'exists:events,id'], $rules['from']);
        $this->assertEquals(['required', 'integer', 'exists:events,id'], $rules['to']);
    }
}
