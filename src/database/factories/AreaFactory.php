<?php

namespace Database\Factories;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    protected $model = Area::class;

    public function definition()
    {
        $areaNames = ['東京都', '大阪府', '福岡県'];

        return [
            'area_name' => $this->faker->randomElement($areaNames)
        ];
    }
}