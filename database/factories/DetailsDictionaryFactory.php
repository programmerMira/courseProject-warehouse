<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Detail;
use App\DetailsDictionary;
use App\Transport;

class DetailsDictionaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DetailsDictionary::class;

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
            'qty' => $this->faker->randomFloat(0, 0, 9999999999.),
            'unit' => $this->faker->word,
            'transportId' => $this->faker->randomElement($transportsIDs),
            'productId' => $this->faker->randomElement($productsIDs),
        ];
    }
}
