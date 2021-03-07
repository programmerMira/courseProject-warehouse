<?php

namespace Tests\Feature\Http\Controllers;

use App\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\WarehouseController
 */
class WarehouseControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $warehouses = Warehouse::factory()->count(3)->create();

        $response = $this->get(route('warehouse.index'));

        $response->assertOk();
        $response->assertViewIs('warehouse.index');
        $response->assertViewHas('warehouses');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('warehouse.create'));

        $response->assertOk();
        $response->assertViewIs('warehouse.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\WarehouseController::class,
            'store',
            \App\Http\Requests\WarehouseStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);

        $response = $this->post(route('warehouse.store'), [
            'title' => $title,
        ]);

        $warehouses = Warehouse::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $warehouses);
        $warehouse = $warehouses->first();

        $response->assertRedirect(route('warehouse.index'));
        $response->assertSessionHas('warehouse.id', $warehouse->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $warehouse = Warehouse::factory()->create();

        $response = $this->get(route('warehouse.show', $warehouse));

        $response->assertOk();
        $response->assertViewIs('warehouse.show');
        $response->assertViewHas('warehouse');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $warehouse = Warehouse::factory()->create();

        $response = $this->get(route('warehouse.edit', $warehouse));

        $response->assertOk();
        $response->assertViewIs('warehouse.edit');
        $response->assertViewHas('warehouse');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\WarehouseController::class,
            'update',
            \App\Http\Requests\WarehouseUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $warehouse = Warehouse::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('warehouse.update', $warehouse), [
            'title' => $title,
        ]);

        $warehouse->refresh();

        $response->assertRedirect(route('warehouse.index'));
        $response->assertSessionHas('warehouse.id', $warehouse->id);

        $this->assertEquals($title, $warehouse->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $warehouse = Warehouse::factory()->create();

        $response = $this->delete(route('warehouse.destroy', $warehouse));

        $response->assertRedirect(route('warehouse.index'));

        $this->assertDeleted($warehouse);
    }
}
