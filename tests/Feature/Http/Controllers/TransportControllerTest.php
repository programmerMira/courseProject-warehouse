<?php

namespace Tests\Feature\Http\Controllers;

use App\Transport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TransportController
 */
class TransportControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $transports = Transport::factory()->count(3)->create();

        $response = $this->get(route('transport.index'));

        $response->assertOk();
        $response->assertViewIs('transport.index');
        $response->assertViewHas('transports');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('transport.create'));

        $response->assertOk();
        $response->assertViewIs('transport.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TransportController::class,
            'store',
            \App\Http\Requests\TransportStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);

        $response = $this->post(route('transport.store'), [
            'title' => $title,
        ]);

        $transports = Transport::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $transports);
        $transport = $transports->first();

        $response->assertRedirect(route('transport.index'));
        $response->assertSessionHas('transport.id', $transport->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $transport = Transport::factory()->create();

        $response = $this->get(route('transport.show', $transport));

        $response->assertOk();
        $response->assertViewIs('transport.show');
        $response->assertViewHas('transport');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $transport = Transport::factory()->create();

        $response = $this->get(route('transport.edit', $transport));

        $response->assertOk();
        $response->assertViewIs('transport.edit');
        $response->assertViewHas('transport');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TransportController::class,
            'update',
            \App\Http\Requests\TransportUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $transport = Transport::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('transport.update', $transport), [
            'title' => $title,
        ]);

        $transport->refresh();

        $response->assertRedirect(route('transport.index'));
        $response->assertSessionHas('transport.id', $transport->id);

        $this->assertEquals($title, $transport->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $transport = Transport::factory()->create();

        $response = $this->delete(route('transport.destroy', $transport));

        $response->assertRedirect(route('transport.index'));

        $this->assertDeleted($transport);
    }
}
