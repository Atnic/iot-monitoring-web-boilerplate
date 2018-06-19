<?php

namespace Tests\Feature;

use App\DeviceParameter;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeviceParameterControllerTest extends TestCase
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(User::class)->create();

        $device_parameters = factory(DeviceParameter::class, 5)->create();

        $this->actingAs($user);
        $response = $this->get(route('device_parameters.index'));
        $response->assertViewIs('device_parameters.index');
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
        $response = $this->get(route('device_parameters.create'));
        $response->assertViewIs('device_parameters.create');
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
        $response = $this->post(route('device_parameters.store'), factory(DeviceParameter::class)->make()->toArray());
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

        $device_parameter = factory(DeviceParameter::class)->create();

        $this->actingAs($user);
        $response = $this->get(route('device_parameters.show', [ $device_parameter->getKey() ]));
        $response->assertViewIs('device_parameters.show');
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testEdit()
    {
        $user = factory(User::class)->create();

        $device_parameter = factory(DeviceParameter::class)->create();

        $this->actingAs($user);
        $response = $this->get(route('device_parameters.edit', [ $device_parameter->getKey() ]));
        $response->assertViewIs('device_parameters.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = factory(User::class)->create();

        $device_parameter = factory(DeviceParameter::class)->create();

        $this->actingAs($user);
        $response = $this->put(route('device_parameters.update', [ $device_parameter->getKey() ]), factory(DeviceParameter::class)->make()->toArray());
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

        $device_parameter = factory(DeviceParameter::class)->create();

        $this->actingAs($user);
        $response = $this->delete(route('device_parameters.destroy', [ $device_parameter->getKey() ]));
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }
}
