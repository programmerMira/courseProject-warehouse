<?php

namespace Tests\Feature\Http\Controllers;

use App\ContractId;
use App\Product;
use App\ProviderId;
use App\SnippedUserId;
use App\TypeId;
use App\WarehouseId;
use App\WaybillId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProductController
 */
class ProductControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $products = Product::factory()->count(3)->create();

        $response = $this->get(route('product.index'));

        $response->assertOk();
        $response->assertViewIs('product.index');
        $response->assertViewHas('products');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('product.create'));

        $response->assertOk();
        $response->assertViewIs('product.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'store',
            \App\Http\Requests\ProductStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);
        $price = $this->faker->randomFloat(/** decimal_attributes **/);
        $createdAt = $this->faker->;
        $qty = $this->faker->randomFloat(/** double_attributes **/);
        $unit = $this->faker->word;
        $providerId = ProviderId::factory()->create();
        $typeId = TypeId::factory()->create();
        $waybillId = WaybillId::factory()->create();
        $contractId = ContractId::factory()->create();
        $warehouseId = WarehouseId::factory()->create();
        $snippedUserId = SnippedUserId::factory()->create();

        $response = $this->post(route('product.store'), [
            'title' => $title,
            'price' => $price,
            'createdAt' => $createdAt,
            'qty' => $qty,
            'unit' => $unit,
            'providerId' => $providerId->id,
            'typeId' => $typeId->id,
            'waybillId' => $waybillId->id,
            'contractId' => $contractId->id,
            'warehouseId' => $warehouseId->id,
            'snippedUserId' => $snippedUserId->id,
        ]);

        $products = Product::query()
            ->where('title', $title)
            ->where('price', $price)
            ->where('createdAt', $createdAt)
            ->where('qty', $qty)
            ->where('unit', $unit)
            ->where('providerId', $providerId->id)
            ->where('typeId', $typeId->id)
            ->where('waybillId', $waybillId->id)
            ->where('contractId', $contractId->id)
            ->where('warehouseId', $warehouseId->id)
            ->where('snippedUserId', $snippedUserId->id)
            ->get();
        $this->assertCount(1, $products);
        $product = $products->first();

        $response->assertRedirect(route('product.index'));
        $response->assertSessionHas('product.id', $product->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('product.show', $product));

        $response->assertOk();
        $response->assertViewIs('product.show');
        $response->assertViewHas('product');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('product.edit', $product));

        $response->assertOk();
        $response->assertViewIs('product.edit');
        $response->assertViewHas('product');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'update',
            \App\Http\Requests\ProductUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $product = Product::factory()->create();
        $title = $this->faker->sentence(4);
        $price = $this->faker->randomFloat(/** decimal_attributes **/);
        $createdAt = $this->faker->;
        $qty = $this->faker->randomFloat(/** double_attributes **/);
        $unit = $this->faker->word;
        $providerId = ProviderId::factory()->create();
        $typeId = TypeId::factory()->create();
        $waybillId = WaybillId::factory()->create();
        $contractId = ContractId::factory()->create();
        $warehouseId = WarehouseId::factory()->create();
        $snippedUserId = SnippedUserId::factory()->create();

        $response = $this->put(route('product.update', $product), [
            'title' => $title,
            'price' => $price,
            'createdAt' => $createdAt,
            'qty' => $qty,
            'unit' => $unit,
            'providerId' => $providerId->id,
            'typeId' => $typeId->id,
            'waybillId' => $waybillId->id,
            'contractId' => $contractId->id,
            'warehouseId' => $warehouseId->id,
            'snippedUserId' => $snippedUserId->id,
        ]);

        $product->refresh();

        $response->assertRedirect(route('product.index'));
        $response->assertSessionHas('product.id', $product->id);

        $this->assertEquals($title, $product->title);
        $this->assertEquals($price, $product->price);
        $this->assertEquals($createdAt, $product->createdAt);
        $this->assertEquals($qty, $product->qty);
        $this->assertEquals($unit, $product->unit);
        $this->assertEquals($providerId->id, $product->providerId);
        $this->assertEquals($typeId->id, $product->typeId);
        $this->assertEquals($waybillId->id, $product->waybillId);
        $this->assertEquals($contractId->id, $product->contractId);
        $this->assertEquals($warehouseId->id, $product->warehouseId);
        $this->assertEquals($snippedUserId->id, $product->snippedUserId);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('product.destroy', $product));

        $response->assertRedirect(route('product.index'));

        $this->assertDeleted($product);
    }
}
