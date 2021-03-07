<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Detail;
use App\DetailsCard;
use App\Transport;
use Carbon\Carbon;

class DetailsCardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DetailsCard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $productsIDs = \DB::table('products')->pluck('id');
        $transportsIDs = \DB::table('transports')->pluck('id');
        return [
            'date' => Carbon::now(),
            'document' => $this->faker->word,
            'qty' => $this->faker->randomFloat(0, 0, 9999999999.),
            'unit' => $this->faker->word,
            'productId' => $this->faker->randomElement($productsIDs),
            'transportId' => $this->faker->randomElement($transportsIDs),
        ];
    }
}
