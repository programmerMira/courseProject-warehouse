<?php

namespace Tests\Feature\Http\Controllers;

use App\TransportType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TransportTypeController
 */
class TransportTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $transportTypes = TransportType::factory()->count(3)->create();

        $response = $this->get(route('transport-type.index'));

        $response->assertOk();
        $response->assertViewIs('transportType.index');
        $response->assertViewHas('transportTypes');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('transport-type.create'));

        $response->assertOk();
        $response->assertViewIs('transportType.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TransportTypeController::class,
            'store',
            \App\Http\Requests\TransportTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);

        $response = $this->post(route('transport-type.store'), [
            'title' => $title,
        ]);

        $transportTypes = TransportType::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $transportTypes);
        $transportType = $transportTypes->first();

        $response->assertRedirect(route('transportType.index'));
        $response->assertSessionHas('transportType.id', $transportType->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $transportType = TransportType::factory()->create();

        $response = $this->get(route('transport-type.show', $transportType));

        $response->assertOk();
        $response->assertViewIs('transportType.show');
        $response->assertViewHas('transportType');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $transportType = TransportType::factory()->create();

        $response = $this->get(route('transport-type.edit', $transportType));

        $response->assertOk();
        $response->assertViewIs('transportType.edit');
        $response->assertViewHas('transportType');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TransportTypeController::class,
            'update',
            \App\Http\Requests\TransportTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $transportType = TransportType::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('transport-type.update', $transportType), [
            'title' => $title,
        ]);

        $transportType->refresh();

        $response->assertRedirect(route('transportType.index'));
        $response->assertSessionHas('transportType.id', $transportType->id);

        $this->assertEquals($title, $transportType->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $transportType = TransportType::factory()->create();

        $response = $this->delete(route('transport-type.destroy', $transportType));

        $response->assertRedirect(route('transportType.index'));

        $this->assertDeleted($transportType);
    }
}
