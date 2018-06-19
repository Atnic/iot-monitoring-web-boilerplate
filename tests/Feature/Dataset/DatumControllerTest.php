<?php

namespace Tests\Feature\Dataset;

use App\Datum;
use App\Dataset;
use App\User;
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
        $user = factory(User::class)->create();

        $dataset = factory(Dataset::class)->create();
        $data = $dataset->data()->saveMany(factory(Datum::class, 5)->make([ $dataset->getForeignKey() => $dataset->getKey() ]));

        $this->actingAs($user);
        $response = $this->get(route('datasets.data.index', [ $dataset->getKey() ]));
        $response->assertViewIs('datasets.data.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function testCreate()
    {
        $user = factory(User::class)->create();

        $dataset = factory(Dataset::class)->create();

        $this->actingAs($user);
        $response = $this->get(route('datasets.data.create', [ $dataset->getKey() ]));
        $response->assertViewIs('datasets.data.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function testStore()
    {
        $user = factory(User::class)->create();

        $dataset = factory(Dataset::class)->create();

        $this->actingAs($user);
        $response = $this->post(route('datasets.data.store', [ $dataset->getKey() ]), factory(Datum::class)->make([ $dataset->getForeignKey() => $dataset->getKey() ])->toArray());
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

        $dataset = factory(Dataset::class)->create();
        $datum = $dataset->data()->save(factory(Datum::class)->make([ $dataset->getForeignKey() => $dataset->getKey() ]));

        $this->actingAs($user);
        $response = $this->get(route('datasets.data.show', [ $dataset->getKey(), $datum->getKey() ]));
        $response->assertViewIs('datasets.data.show');
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testEdit()
    {
        $user = factory(User::class)->create();

        $dataset = factory(Dataset::class)->create();
        $datum = $dataset->data()->save(factory(Datum::class)->make([ $dataset->getForeignKey() => $dataset->getKey() ]));

        $this->actingAs($user);
        $response = $this->get(route('datasets.data.edit', [ $dataset->getKey(), $datum->getKey()  ]));
        $response->assertViewIs('datasets.data.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = factory(User::class)->create();

        $dataset = factory(Dataset::class)->create();
        $datum = $dataset->data()->save(factory(Datum::class)->make([ $dataset->getForeignKey() => $dataset->getKey() ]));

        $this->actingAs($user);
        $response = $this->put(route('datasets.data.update', [ $dataset->getKey(), $datum->getKey()  ]), factory(Datum::class)->make([ $dataset->getForeignKey() => $dataset->getKey() ])->toArray());
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

        $dataset = factory(Dataset::class)->create();
        $datum = $dataset->data()->save(factory(Datum::class)->make([ $dataset->getForeignKey() => $dataset->getKey() ]));

        $this->actingAs($user);
        $response = $this->delete(route('datasets.data.destroy', [ $dataset->getKey(), $datum->getKey()  ]));
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }
}
