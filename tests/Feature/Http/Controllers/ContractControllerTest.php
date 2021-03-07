<?php

namespace Tests\Feature\Http\Controllers;

use App\Contract;
use App\ProviderId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContractController
 */
class ContractControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $contracts = Contract::factory()->count(3)->create();

        $response = $this->get(route('contract.index'));

        $response->assertOk();
        $response->assertViewIs('contract.index');
        $response->assertViewHas('contracts');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('contract.create'));

        $response->assertOk();
        $response->assertViewIs('contract.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractController::class,
            'store',
            \App\Http\Requests\ContractStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);
        $date = $this->faker->;
        $productQty = $this->faker->numberBetween(-10000, 10000);
        $priceSum = $this->faker->randomFloat(/** double_attributes **/);
        $providerId = ProviderId::factory()->create();

        $response = $this->post(route('contract.store'), [
            'title' => $title,
            'date' => $date,
            'productQty' => $productQty,
            'priceSum' => $priceSum,
            'providerId' => $providerId->id,
        ]);

        $contracts = Contract::query()
            ->where('title', $title)
            ->where('date', $date)
            ->where('productQty', $productQty)
            ->where('priceSum', $priceSum)
            ->where('providerId', $providerId->id)
            ->get();
        $this->assertCount(1, $contracts);
        $contract = $contracts->first();

        $response->assertRedirect(route('contract.index'));
        $response->assertSessionHas('contract.id', $contract->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $contract = Contract::factory()->create();

        $response = $this->get(route('contract.show', $contract));

        $response->assertOk();
        $response->assertViewIs('contract.show');
        $response->assertViewHas('contract');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $contract = Contract::factory()->create();

        $response = $this->get(route('contract.edit', $contract));

        $response->assertOk();
        $response->assertViewIs('contract.edit');
        $response->assertViewHas('contract');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractController::class,
            'update',
            \App\Http\Requests\ContractUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $contract = Contract::factory()->create();
        $title = $this->faker->sentence(4);
        $date = $this->faker->;
        $productQty = $this->faker->numberBetween(-10000, 10000);
        $priceSum = $this->faker->randomFloat(/** double_attributes **/);
        $providerId = ProviderId::factory()->create();

        $response = $this->put(route('contract.update', $contract), [
            'title' => $title,
            'date' => $date,
            'productQty' => $productQty,
            'priceSum' => $priceSum,
            'providerId' => $providerId->id,
        ]);

        $contract->refresh();

        $response->assertRedirect(route('contract.index'));
        $response->assertSessionHas('contract.id', $contract->id);

        $this->assertEquals($title, $contract->title);
        $this->assertEquals($date, $contract->date);
        $this->assertEquals($productQty, $contract->productQty);
        $this->assertEquals($priceSum, $contract->priceSum);
        $this->assertEquals($providerId->id, $contract->providerId);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $contract = Contract::factory()->create();

        $response = $this->delete(route('contract.destroy', $contract));

        $response->assertRedirect(route('contract.index'));

        $this->assertDeleted($contract);
    }
}
