<?php

namespace Tests\Feature\ApiDevice\Auth;

use App\Device;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    /**
     * Invoke single action controller.
     *
     * @return \Illuminate\Http\Response
     */
    public function testLogin()
    {
        $device = factory(Device::class)->create();

        $this->actingAs($device, 'api_device');
        $response = $this->postJson(route('api.device.login'),[
            'imei' => (string) $device->imei
        ]);
        $response->assertSuccessful();
    }


      /**
       * Invoke single action controller.
       *
       * @return \Illuminate\Http\Response
       */
      public function testLogout()
      {
          $device = factory(Device::class)->create();

          $this->actingAs($device, 'api_device');
          $response = $this->postJson(route('api.device.logout'),[
              'imei' => (string) $device->imei
          ]);
          $response->assertSuccessful();
      }
}
