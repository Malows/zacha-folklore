<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\BaseRequest as Request;
use PHPUnit\Framework\TestCase;

class BaseRequestTest extends TestCase
{
    protected $validator = Request::class;

    /**
     * Check if the FormRequest is authorized
     *
     * @return void
     */
    public function testAuthorized()
    {
        $this->assertTrue((new $this->validator())->authorize());
    }

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

        $this->assertEquals(0, count($keys));
        $this->assertEquals([], $keys);
    }
}
