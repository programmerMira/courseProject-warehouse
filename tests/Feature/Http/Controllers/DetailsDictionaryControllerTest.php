<?php

namespace Tests\Feature\Http\Controllers;

use App\DetailId;
use App\DetailsDictionary;
use App\TransportId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DetailsDictionaryController
 */
class DetailsDictionaryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $detailsDictionaries = DetailsDictionary::factory()->count(3)->create();

        $response = $this->get(route('details-dictionary.index'));

        $response->assertOk();
        $response->assertViewIs('detailsDictionary.index');
        $response->assertViewHas('detailsDictionaries');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('details-dictionary.create'));

        $response->assertOk();
        $response->assertViewIs('detailsDictionary.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DetailsDictionaryController::class,
            'store',
            \App\Http\Requests\DetailsDictionaryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $qty = $this->faker->randomFloat(/** double_attributes **/);
        $unit = $this->faker->word;
        $transportId = TransportId::factory()->create();
        $detailId = DetailId::factory()->create();

        $response = $this->post(route('details-dictionary.store'), [
            'qty' => $qty,
            'unit' => $unit,
            'transportId' => $transportId->id,
            'detailId' => $detailId->id,
        ]);

        $detailsDictionaries = DetailsDictionary::query()
            ->where('qty', $qty)
            ->where('unit', $unit)
            ->where('transportId', $transportId->id)
            ->where('detailId', $detailId->id)
            ->get();
        $this->assertCount(1, $detailsDictionaries);
        $detailsDictionary = $detailsDictionaries->first();

        $response->assertRedirect(route('detailsDictionary.index'));
        $response->assertSessionHas('detailsDictionary.id', $detailsDictionary->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $detailsDictionary = DetailsDictionary::factory()->create();

        $response = $this->get(route('details-dictionary.show', $detailsDictionary));

        $response->assertOk();
        $response->assertViewIs('detailsDictionary.show');
        $response->assertViewHas('detailsDictionary');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $detailsDictionary = DetailsDictionary::factory()->create();

        $response = $this->get(route('details-dictionary.edit', $detailsDictionary));

        $response->assertOk();
        $response->assertViewIs('detailsDictionary.edit');
        $response->assertViewHas('detailsDictionary');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DetailsDictionaryController::class,
            'update',
            \App\Http\Requests\DetailsDictionaryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $detailsDictionary = DetailsDictionary::factory()->create();
        $qty = $this->faker->randomFloat(/** double_attributes **/);
        $unit = $this->faker->word;
        $transportId = TransportId::factory()->create();
        $detailId = DetailId::factory()->create();

        $response = $this->put(route('details-dictionary.update', $detailsDictionary), [
            'qty' => $qty,
            'unit' => $unit,
            'transportId' => $transportId->id,
            'detailId' => $detailId->id,
        ]);

        $detailsDictionary->refresh();

        $response->assertRedirect(route('detailsDictionary.index'));
        $response->assertSessionHas('detailsDictionary.id', $detailsDictionary->id);

        $this->assertEquals($qty, $detailsDictionary->qty);
        $this->assertEquals($unit, $detailsDictionary->unit);
        $this->assertEquals($transportId->id, $detailsDictionary->transportId);
        $this->assertEquals($detailId->id, $detailsDictionary->detailId);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $detailsDictionary = DetailsDictionary::factory()->create();

        $response = $this->delete(route('details-dictionary.destroy', $detailsDictionary));

        $response->assertRedirect(route('detailsDictionary.index'));

        $this->assertDeleted($detailsDictionary);
    }
}
