<?php

namespace Tests\Feature\ApiDevice;

use App\Datum;
use App\Device;
use App\Dataset;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatumControllerTest extends TestCase
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function testIndex()
    {
        $device = factory(Device::class)->create();

        $dataset = factory(Dataset::class)->create();
        $dataset->device()->sync($device->getKey());
        $data = factory(Datum::class, 5)->create([ $dataset->getForeignKey() => $dataset->getKey() ]);

        $this->actingAs($device, 'api_device');
        $response = $this->getJson(route('api.device.data.index'));
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

        $dataset = factory(Dataset::class)->create();
        $dataset->device()->sync($device->getKey());

        $this->actingAs($device, 'api_device');
        $response = $this->postJson(route('api.device.data.store'), factory(Datum::class)->make()->toArray());
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

        $dataset = factory(Dataset::class)->create();
        $dataset->device()->sync($device->getKey());
        $datum = factory(Datum::class)->create([ $dataset->getForeignKey() => $dataset->getKey() ]);

        $this->actingAs($device, 'api_device');
        $response = $this->getJson(route('api.device.data.show', [ $datum->getKey() ]));
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

        $dataset = factory(Dataset::class)->create();
        $dataset->device()->sync($device->getKey());
        $datum = factory(Datum::class)->create([ $dataset->getForeignKey() => $dataset->getKey() ]);

        $this->actingAs($device, 'api_device');
        $response = $this->putJson(route('api.device.data.update', [ $datum->getKey() ]), factory(Datum::class)->make()->toArray());
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

        $dataset = factory(Dataset::class)->create();
        $dataset->device()->sync($device->getKey());
        $datum = factory(Datum::class)->create([ $dataset->getForeignKey() => $dataset->getKey() ]);

        $this->actingAs($device, 'api_device');
        $response = $this->deleteJson(route('api.device.data.destroy', [ $datum->getKey() ]));
        $response->assertSuccessful();
    }
}
