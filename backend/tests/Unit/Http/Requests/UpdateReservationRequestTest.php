<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\UpdateReservationRequest as Request;

class UpdateReservationRequestTest extends BaseRequestTest
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


        $this->assertEquals(5, count($keys));
        $this->assertEquals(['amount', 'email', 'last_name', 'name', 'phone'], $keys);
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
        $this->assertEquals(['required', 'string', 'max:255'], $rules['last_name']);
        $this->assertEquals(['nullable', 'integer', 'min:1'], $rules['amount']);
        $this->assertEquals(['nullable', 'string', 'email', 'max:255'], $rules['email']);
        $this->assertEquals(['nullable', 'string', 'max:255'], $rules['phone']);
    }
}
