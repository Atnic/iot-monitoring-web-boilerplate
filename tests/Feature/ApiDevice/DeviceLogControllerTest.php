<?php

namespace Tests\Feature\ApiDevice;

use App\DeviceLog;
use App\Device;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeviceLogControllerTest extends TestCase
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function testIndex()
    {
        $device = factory(Device::class)->create();

        $device_logs = factory(DeviceLog::class, 5)->create([ $device->getForeignKey() => $device->getKey() ]);

        $this->actingAs($device, 'api_device');
        $response = $this->getJson(route('api.device.device_logs.index'));
        $response->assertSuccessful();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function testStore()
    {
        $device = factory(Device::class)->create();

        $this->actingAs($device, 'api_device');
        $response = $this->postJson(route('api.device.device_logs.store'), factory(DeviceLog::class)->make()->toArray());
        $response->assertSuccessful();
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testShow()
    {
        $device = factory(Device::class)->create();

        $device_log = factory(DeviceLog::class)->create([ $device->getForeignKey() => $device->getKey() ]);

        $this->actingAs($device, 'api_device');
        $response = $this->getJson(route('api.device.device_logs.show', [ $device_log->getKey() ]));
        $response->assertSuccessful();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return void
     */
    public function testUpdate()
    {
        $device = factory(Device::class)->create();

        $device_log = factory(DeviceLog::class)->create([ $device->getForeignKey() => $device->getKey() ]);

        $this->actingAs($device, 'api_device');
        $response = $this->putJson(route('api.device.device_logs.update', [ $device_log->getKey() ]), factory(DeviceLog::class)->make()->toArray());
        $response->assertSuccessful();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return void
     */
    public function testDestroy()
    {
        $device = factory(Device::class)->create();

        $device_log = factory(DeviceLog::class)->create([ $device->getForeignKey() => $device->getKey() ]);

        $this->actingAs($device, 'api_device');
        $response = $this->deleteJson(route('api.device.device_logs.destroy', [ $device_log->getKey() ]));
        $response->assertSuccessful();
    }
}
