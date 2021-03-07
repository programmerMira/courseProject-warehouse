<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Provider;

class ProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Provider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'phone' => $this->faker->phoneNumber,
            'code' => $this->faker->word,
            'inn' => $this->faker->word,
            'certificateNumber' => $this->faker->numberBetween(-10000, 10000),
            'adress' => $this->faker->word,
        ];
    }
}
