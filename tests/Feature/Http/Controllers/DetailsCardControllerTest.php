<?php

namespace Tests\Feature\Http\Controllers;

use App\DetailId;
use App\DetailsCard;
use App\TransportId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DetailsCardController
 */
class DetailsCardControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $detailsCards = DetailsCard::factory()->count(3)->create();

        $response = $this->get(route('details-card.index'));

        $response->assertOk();
        $response->assertViewIs('detailsCard.index');
        $response->assertViewHas('detailsCards');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('details-card.create'));

        $response->assertOk();
        $response->assertViewIs('detailsCard.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DetailsCardController::class,
            'store',
            \App\Http\Requests\DetailsCardStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $date = $this->faker->;
        $document = $this->faker->word;
        $qty = $this->faker->randomFloat(/** double_attributes **/);
        $unit = $this->faker->word;
        $detailId = DetailId::factory()->create();
        $transportId = TransportId::factory()->create();

        $response = $this->post(route('details-card.store'), [
            'date' => $date,
            'document' => $document,
            'qty' => $qty,
            'unit' => $unit,
            'detailId' => $detailId->id,
            'transportId' => $transportId->id,
        ]);

        $detailsCards = DetailsCard::query()
            ->where('date', $date)
            ->where('document', $document)
            ->where('qty', $qty)
            ->where('unit', $unit)
            ->where('detailId', $detailId->id)
            ->where('transportId', $transportId->id)
            ->get();
        $this->assertCount(1, $detailsCards);
        $detailsCard = $detailsCards->first();

        $response->assertRedirect(route('detailsCard.index'));
        $response->assertSessionHas('detailsCard.id', $detailsCard->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $detailsCard = DetailsCard::factory()->create();

        $response = $this->get(route('details-card.show', $detailsCard));

        $response->assertOk();
        $response->assertViewIs('detailsCard.show');
        $response->assertViewHas('detailsCard');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $detailsCard = DetailsCard::factory()->create();

        $response = $this->get(route('details-card.edit', $detailsCard));

        $response->assertOk();
        $response->assertViewIs('detailsCard.edit');
        $response->assertViewHas('detailsCard');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DetailsCardController::class,
            'update',
            \App\Http\Requests\DetailsCardUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $detailsCard = DetailsCard::factory()->create();
        $date = $this->faker->;
        $document = $this->faker->word;
        $qty = $this->faker->randomFloat(/** double_attributes **/);
        $unit = $this->faker->word;
        $detailId = DetailId::factory()->create();
        $transportId = TransportId::factory()->create();

        $response = $this->put(route('details-card.update', $detailsCard), [
            'date' => $date,
            'document' => $document,
            'qty' => $qty,
            'unit' => $unit,
            'detailId' => $detailId->id,
            'transportId' => $transportId->id,
        ]);

        $detailsCard->refresh();

        $response->assertRedirect(route('detailsCard.index'));
        $response->assertSessionHas('detailsCard.id', $detailsCard->id);

        $this->assertEquals($date, $detailsCard->date);
        $this->assertEquals($document, $detailsCard->document);
        $this->assertEquals($qty, $detailsCard->qty);
        $this->assertEquals($unit, $detailsCard->unit);
        $this->assertEquals($detailId->id, $detailsCard->detailId);
        $this->assertEquals($transportId->id, $detailsCard->transportId);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $detailsCard = DetailsCard::factory()->create();

        $response = $this->delete(route('details-card.destroy', $detailsCard));

        $response->assertRedirect(route('detailsCard.index'));

        $this->assertDeleted($detailsCard);
    }
}
