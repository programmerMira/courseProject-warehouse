<?php

namespace Tests\Feature\Http\Controllers;

use App\Detail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DetailController
 */
class DetailControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $details = Detail::factory()->count(3)->create();

        $response = $this->get(route('detail.index'));

        $response->assertOk();
        $response->assertViewIs('detail.index');
        $response->assertViewHas('details');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('detail.create'));

        $response->assertOk();
        $response->assertViewIs('detail.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DetailController::class,
            'store',
            \App\Http\Requests\DetailStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $vendorCode = $this->faker->word;
        $title = $this->faker->sentence(4);
        $qty = $this->faker->numberBetween(-10000, 10000);
        $usedQty = $this->faker->numberBetween(-10000, 10000);
        $writtenOffQty = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('detail.store'), [
            'vendorCode' => $vendorCode,
            'title' => $title,
            'qty' => $qty,
            'usedQty' => $usedQty,
            'writtenOffQty' => $writtenOffQty,
        ]);

        $details = Detail::query()
            ->where('vendorCode', $vendorCode)
            ->where('title', $title)
            ->where('qty', $qty)
            ->where('usedQty', $usedQty)
            ->where('writtenOffQty', $writtenOffQty)
            ->get();
        $this->assertCount(1, $details);
        $detail = $details->first();

        $response->assertRedirect(route('detail.index'));
        $response->assertSessionHas('detail.id', $detail->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $detail = Detail::factory()->create();

        $response = $this->get(route('detail.show', $detail));

        $response->assertOk();
        $response->assertViewIs('detail.show');
        $response->assertViewHas('detail');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $detail = Detail::factory()->create();

        $response = $this->get(route('detail.edit', $detail));

        $response->assertOk();
        $response->assertViewIs('detail.edit');
        $response->assertViewHas('detail');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DetailController::class,
            'update',
            \App\Http\Requests\DetailUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $detail = Detail::factory()->create();
        $vendorCode = $this->faker->word;
        $title = $this->faker->sentence(4);
        $qty = $this->faker->numberBetween(-10000, 10000);
        $usedQty = $this->faker->numberBetween(-10000, 10000);
        $writtenOffQty = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('detail.update', $detail), [
            'vendorCode' => $vendorCode,
            'title' => $title,
            'qty' => $qty,
            'usedQty' => $usedQty,
            'writtenOffQty' => $writtenOffQty,
        ]);

        $detail->refresh();

        $response->assertRedirect(route('detail.index'));
        $response->assertSessionHas('detail.id', $detail->id);

        $this->assertEquals($vendorCode, $detail->vendorCode);
        $this->assertEquals($title, $detail->title);
        $this->assertEquals($qty, $detail->qty);
        $this->assertEquals($usedQty, $detail->usedQty);
        $this->assertEquals($writtenOffQty, $detail->writtenOffQty);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $detail = Detail::factory()->create();

        $response = $this->delete(route('detail.destroy', $detail));

        $response->assertRedirect(route('detail.index'));

        $this->assertDeleted($detail);
    }
}
