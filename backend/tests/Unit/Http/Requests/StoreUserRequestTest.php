<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\StoreUserRequest as Request;

class StoreUserRequestTest extends BaseRequestTest
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
        $this->assertEquals(['email', 'name', 'password'], $keys);
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
        $this->assertEquals(['required', 'string', 'email', 'max:255', 'unique:users'], $rules['email']);
        $this->assertEquals(['required', 'string', 'min:8', 'confirmed'], $rules['password']);
    }
}
