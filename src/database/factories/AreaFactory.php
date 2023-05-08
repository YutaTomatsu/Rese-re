<?php

namespace Database\Factories;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    protected $model = Area::class;

    public function definition()
    {
        return [
            'area_name' => $this->faker->unique()->randomElement(['東京都', '大阪府', '福岡県']),
        ];
    }
}