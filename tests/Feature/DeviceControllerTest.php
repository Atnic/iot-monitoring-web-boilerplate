<?php

namespace Tests\Feature;

use App\Device;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeviceControllerTest extends TestCase
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(User::class)->create();

        $devices = factory(Device::class, 5)->create();

        $this->actingAs($user);
        $response = $this->get(route('devices.index'));
        $response->assertViewIs('devices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function testCreate()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $response = $this->get(route('devices.create'));
        $response->assertViewIs('devices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function testStore()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $response = $this->post(route('devices.store'), factory(Device::class)->make()->toArray());
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

        $this->actingAs($user);
        $response = $this->get(route('devices.show', [ $device->getKey() ]));
        $response->assertViewIs('devices.show');
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

        $this->actingAs($user);
        $response = $this->get(route('devices.edit', [ $device->getKey() ]));
        $response->assertViewIs('devices.edit');
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

        $this->actingAs($user);
        $response = $this->put(route('devices.update', [ $device->getKey() ]), factory(Device::class)->make()->toArray());
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

        $this->actingAs($user);
        $response = $this->delete(route('devices.destroy', [ $device->getKey() ]));
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }
}
