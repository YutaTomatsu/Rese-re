<?php

namespace Database\Factories;

use App\Models\Cource;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shop_id' => 1,
            'cource_1' => '1000円コース',
            'cource_2' => '10000円コース',
            'cource_3' => '100000円コース',
        ];
    }
}
