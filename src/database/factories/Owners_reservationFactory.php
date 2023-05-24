<?php

namespace Database\Factories;

use App\Models\Owners_reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class Owners_reservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Owners_reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 3,
            'shop_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
