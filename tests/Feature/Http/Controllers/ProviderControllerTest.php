<?php

namespace Tests\Feature\Http\Controllers;

use App\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProviderController
 */
class ProviderControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $providers = Provider::factory()->count(3)->create();

        $response = $this->get(route('provider.index'));

        $response->assertOk();
        $response->assertViewIs('provider.index');
        $response->assertViewHas('providers');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('provider.create'));

        $response->assertOk();
        $response->assertViewIs('provider.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProviderController::class,
            'store',
            \App\Http\Requests\ProviderStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);
        $phone = $this->faker->phoneNumber;
        $code = $this->faker->word;
        $inn = $this->faker->word;
        $certificateNumber = $this->faker->numberBetween(-10000, 10000);
        $adress = $this->faker->word;

        $response = $this->post(route('provider.store'), [
            'title' => $title,
            'phone' => $phone,
            'code' => $code,
            'inn' => $inn,
            'certificateNumber' => $certificateNumber,
            'adress' => $adress,
        ]);

        $providers = Provider::query()
            ->where('title', $title)
            ->where('phone', $phone)
            ->where('code', $code)
            ->where('inn', $inn)
            ->where('certificateNumber', $certificateNumber)
            ->where('adress', $adress)
            ->get();
        $this->assertCount(1, $providers);
        $provider = $providers->first();

        $response->assertRedirect(route('provider.index'));
        $response->assertSessionHas('provider.id', $provider->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $provider = Provider::factory()->create();

        $response = $this->get(route('provider.show', $provider));

        $response->assertOk();
        $response->assertViewIs('provider.show');
        $response->assertViewHas('provider');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $provider = Provider::factory()->create();

        $response = $this->get(route('provider.edit', $provider));

        $response->assertOk();
        $response->assertViewIs('provider.edit');
        $response->assertViewHas('provider');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProviderController::class,
            'update',
            \App\Http\Requests\ProviderUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $provider = Provider::factory()->create();
        $title = $this->faker->sentence(4);
        $phone = $this->faker->phoneNumber;
        $code = $this->faker->word;
        $inn = $this->faker->word;
        $certificateNumber = $this->faker->numberBetween(-10000, 10000);
        $adress = $this->faker->word;

        $response = $this->put(route('provider.update', $provider), [
            'title' => $title,
            'phone' => $phone,
            'code' => $code,
            'inn' => $inn,
            'certificateNumber' => $certificateNumber,
            'adress' => $adress,
        ]);

        $provider->refresh();

        $response->assertRedirect(route('provider.index'));
        $response->assertSessionHas('provider.id', $provider->id);

        $this->assertEquals($title, $provider->title);
        $this->assertEquals($phone, $provider->phone);
        $this->assertEquals($code, $provider->code);
        $this->assertEquals($inn, $provider->inn);
        $this->assertEquals($certificateNumber, $provider->certificateNumber);
        $this->assertEquals($adress, $provider->adress);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $provider = Provider::factory()->create();

        $response = $this->delete(route('provider.destroy', $provider));

        $response->assertRedirect(route('provider.index'));

        $this->assertDeleted($provider);
    }
}
