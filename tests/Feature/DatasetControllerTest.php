<?php

namespace Tests\Feature;

use App\Dataset;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatasetControllerTest extends TestCase
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(User::class)->create();

        $datasets = factory(Dataset::class, 5)->create();

        $this->actingAs($user);
        $response = $this->get(route('datasets.index'));
        $response->assertViewIs('datasets.index');
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
        $response = $this->get(route('datasets.create'));
        $response->assertViewIs('datasets.create');
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
        $response = $this->post(route('datasets.store'), factory(Dataset::class)->make()->toArray());
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

        $this->actingAs($user);
        $response = $this->get(route('datasets.show', [ $dataset->getKey() ]));
        $response->assertViewIs('datasets.show');
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

        $this->actingAs($user);
        $response = $this->get(route('datasets.edit', [ $dataset->getKey() ]));
        $response->assertViewIs('datasets.edit');
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

        $this->actingAs($user);
        $response = $this->put(route('datasets.update', [ $dataset->getKey() ]), factory(Dataset::class)->make()->toArray());
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

        $this->actingAs($user);
        $response = $this->delete(route('datasets.destroy', [ $dataset->getKey() ]));
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }
}
