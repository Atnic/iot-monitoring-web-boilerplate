<?php

namespace Tests\Feature\Device;

use App\DeviceLog;
use App\Device;
use App\User;
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
        $user = factory(User::class)->create();

        $device = factory(Device::class)->create();
        $device_logs = $device->device_logs()->saveMany(factory(DeviceLog::class, 5)->make([ $device->getForeignKey() => $device->getKey() ]));

        $this->actingAs($user);
        $response = $this->get(route('devices.device_logs.index', [ $device->getKey() ]));
        $response->assertViewIs('devices.device_logs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function testCreate()
    {
        $user = factory(User::class)->create();

        $device = factory(Device::class)->create();

        $this->actingAs($user);
        $response = $this->get(route('devices.device_logs.create', [ $device->getKey() ]));
        $response->assertViewIs('devices.device_logs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function testStore()
    {
        $user = factory(User::class)->create();

        $device = factory(Device::class)->create();

        $this->actingAs($user);
        $response = $this->post(route('devices.device_logs.store', [ $device->getKey() ]), factory(DeviceLog::class)->make([ $device->getForeignKey() => $device->getKey() ])->toArray());
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testShow()
    {
        $user = factory(User::class)->create();

        $device = factory(Device::class)->create();
        $device_log = $device->device_logs()->save(factory(DeviceLog::class)->make([ $device->getForeignKey() => $device->getKey() ]));

        $this->actingAs($user);
        $response = $this->get(route('devices.device_logs.show', [ $device->getKey(), $device_log->getKey() ]));
        $response->assertViewIs('devices.device_logs.show');
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testEdit()
    {
        $user = factory(User::class)->create();

        $device = factory(Device::class)->create();
        $device_log = $device->device_logs()->save(factory(DeviceLog::class)->make([ $device->getForeignKey() => $device->getKey() ]));

        $this->actingAs($user);
        $response = $this->get(route('devices.device_logs.edit', [ $device->getKey(), $device_log->getKey()  ]));
        $response->assertViewIs('devices.device_logs.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = factory(User::class)->create();

        $device = factory(Device::class)->create();
        $device_log = $device->device_logs()->save(factory(DeviceLog::class)->make([ $device->getForeignKey() => $device->getKey() ]));

        $this->actingAs($user);
        $response = $this->put(route('devices.device_logs.update', [ $device->getKey(), $device_log->getKey()  ]), factory(DeviceLog::class)->make([ $device->getForeignKey() => $device->getKey() ])->toArray());
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return void
     */
    public function testDestroy()
    {
        $user = factory(User::class)->create();

        $device = factory(Device::class)->create();
        $device_log = $device->device_logs()->save(factory(DeviceLog::class)->make([ $device->getForeignKey() => $device->getKey() ]));

        $this->actingAs($user);
        $response = $this->delete(route('devices.device_logs.destroy', [ $device->getKey(), $device_log->getKey()  ]));
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }
}
