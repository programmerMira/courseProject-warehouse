<?php

namespace Tests\Feature\Http\Controllers;

use App\Waybill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\WaybillController
 */
class WaybillControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $waybills = Waybill::factory()->count(3)->create();

        $response = $this->get(route('waybill.index'));

        $response->assertOk();
        $response->assertViewIs('waybill.index');
        $response->assertViewHas('waybills');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('waybill.create'));

        $response->assertOk();
        $response->assertViewIs('waybill.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\WaybillController::class,
            'store',
            \App\Http\Requests\WaybillStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);

        $response = $this->post(route('waybill.store'), [
            'title' => $title,
        ]);

        $waybills = Waybill::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $waybills);
        $waybill = $waybills->first();

        $response->assertRedirect(route('waybill.index'));
        $response->assertSessionHas('waybill.id', $waybill->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $waybill = Waybill::factory()->create();

        $response = $this->get(route('waybill.show', $waybill));

        $response->assertOk();
        $response->assertViewIs('waybill.show');
        $response->assertViewHas('waybill');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $waybill = Waybill::factory()->create();

        $response = $this->get(route('waybill.edit', $waybill));

        $response->assertOk();
        $response->assertViewIs('waybill.edit');
        $response->assertViewHas('waybill');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\WaybillController::class,
            'update',
            \App\Http\Requests\WaybillUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $waybill = Waybill::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('waybill.update', $waybill), [
            'title' => $title,
        ]);

        $waybill->refresh();

        $response->assertRedirect(route('waybill.index'));
        $response->assertSessionHas('waybill.id', $waybill->id);

        $this->assertEquals($title, $waybill->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $waybill = Waybill::factory()->create();

        $response = $this->delete(route('waybill.destroy', $waybill));

        $response->assertRedirect(route('waybill.index'));

        $this->assertDeleted($waybill);
    }
}
