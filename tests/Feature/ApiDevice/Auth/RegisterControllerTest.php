<?php

namespace Tests\Feature\ApiDevice\Auth;

use App\Device;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    /**
     * Invoke single action controller.
     *
     * @return \Illuminate\Http\Response
     */
    public function testRegister()
    {
        $response = $this->postJson(route('api.device.register'), [
            'imei' => '1234567890'
        ]);
        $response->assertSuccessful();
    }
}
