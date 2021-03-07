<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Contract;
use App\Product;
use App\Provider;
use App\Type;
use App\User;
use App\Warehouse;
use App\Waybill;
use Carbon\Carbon;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $providersIDs = \DB::table('providers')->pluck('id');
        $usersIDs = \DB::table('users')->pluck('id');
        return [
            'title' => $this->faker->sentence(4),
            'price' => $this->faker->randomFloat(0, 0, 999.),
            'qty' => $this->faker->randomFloat(0, 0, 999.),
            'unit' => $this->faker->word,
            'waybillTitle' => $this->faker->word,
            'contractTitle' => $this->faker->word,
            'date' => Carbon::now(),
            'warehouseTitle' => $this->faker->word,
            'vendorCode' => $this->faker->word,
            'usedQty' => $this->faker->numberBetween(-1000, 1000),
            'writtenOffQty' => $this->faker->numberBetween(-1000, 1000),
            'providerId' => $this->faker->randomElement($providersIDs),
            'snippedUserId' => $this->faker->randomElement($usersIDs),
        ];
    }
}
