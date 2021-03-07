<?php

namespace Tests\Feature\Http\Controllers;

use App\Log;
use App\UserId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LogController
 */
class LogControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $logs = Log::factory()->count(3)->create();

        $response = $this->get(route('log.index'));

        $response->assertOk();
        $response->assertViewIs('log.index');
        $response->assertViewHas('logs');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('log.create'));

        $response->assertOk();
        $response->assertViewIs('log.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LogController::class,
            'store',
            \App\Http\Requests\LogStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $userId = UserId::factory()->create();
        $oldValue = $this->faker->word;
        $newValue = $this->faker->word;

        $response = $this->post(route('log.store'), [
            'userId' => $userId->id,
            'oldValue' => $oldValue,
            'newValue' => $newValue,
        ]);

        $logs = Log::query()
            ->where('userId', $userId->id)
            ->where('oldValue', $oldValue)
            ->where('newValue', $newValue)
            ->get();
        $this->assertCount(1, $logs);
        $log = $logs->first();

        $response->assertRedirect(route('log.index'));
        $response->assertSessionHas('log.id', $log->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $log = Log::factory()->create();

        $response = $this->get(route('log.show', $log));

        $response->assertOk();
        $response->assertViewIs('log.show');
        $response->assertViewHas('log');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $log = Log::factory()->create();

        $response = $this->get(route('log.edit', $log));

        $response->assertOk();
        $response->assertViewIs('log.edit');
        $response->assertViewHas('log');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LogController::class,
            'update',
            \App\Http\Requests\LogUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $log = Log::factory()->create();
        $userId = UserId::factory()->create();
        $oldValue = $this->faker->word;
        $newValue = $this->faker->word;

        $response = $this->put(route('log.update', $log), [
            'userId' => $userId->id,
            'oldValue' => $oldValue,
            'newValue' => $newValue,
        ]);

        $log->refresh();

        $response->assertRedirect(route('log.index'));
        $response->assertSessionHas('log.id', $log->id);

        $this->assertEquals($userId->id, $log->userId);
        $this->assertEquals($oldValue, $log->oldValue);
        $this->assertEquals($newValue, $log->newValue);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $log = Log::factory()->create();

        $response = $this->delete(route('log.destroy', $log));

        $response->assertRedirect(route('log.index'));

        $this->assertDeleted($log);
    }
}
