<?php

namespace Tests\Feature;

use App\Parameter;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParameterControllerTest extends TestCase
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(User::class)->create();

        $parameters = factory(Parameter::class, 5)->create();

        $this->actingAs($user);
        $response = $this->get(route('parameters.index'));
        $response->assertViewIs('parameters.index');
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
        $response = $this->get(route('parameters.create'));
        $response->assertViewIs('parameters.create');
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
        $response = $this->post(route('parameters.store'), factory(Parameter::class)->make()->toArray());
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

        $parameter = factory(Parameter::class)->create();

        $this->actingAs($user);
        $response = $this->get(route('parameters.show', [ $parameter->getKey() ]));
        $response->assertViewIs('parameters.show');
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testEdit()
    {
        $user = factory(User::class)->create();

        $parameter = factory(Parameter::class)->create();

        $this->actingAs($user);
        $response = $this->get(route('parameters.edit', [ $parameter->getKey() ]));
        $response->assertViewIs('parameters.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = factory(User::class)->create();

        $parameter = factory(Parameter::class)->create();

        $this->actingAs($user);
        $response = $this->put(route('parameters.update', [ $parameter->getKey() ]), factory(Parameter::class)->make()->toArray());
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

        $parameter = factory(Parameter::class)->create();

        $this->actingAs($user);
        $response = $this->delete(route('parameters.destroy', [ $parameter->getKey() ]));
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }
}
