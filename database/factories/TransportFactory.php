<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Transport;
use Carbon\Carbon;

class TransportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $transportTypesIDs = \DB::table('transport_types')->pluck('id');
        return [
            'title' => $this->faker->sentence(4),
            'creationDate' => Carbon::now(),
            'commissioningDate' => Carbon::now(),
            'detailsUpdateDate' => Carbon::now(),
            'number' => $this->faker->word,
            'typeId' => $this->faker->randomElement($transportTypesIDs),
            'brand' => $this->faker->word,
            'model' => $this->faker->word,
            'chassis_engine_number' => $this->faker->randomFloat(0, 0, 9999999999.),
            'engine_volume' => $this->faker->randomFloat(0, 0, 9999999999.),
            'weight' => $this->faker->randomFloat(0, 0, 9999999999.),
            'color' => $this->faker->word,
            'certificate' => $this->faker->word,
            'factory_number' => $this->faker->word,
            'rent' => false
        ];
    }
}
