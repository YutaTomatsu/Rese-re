<?php

namespace Database\Factories;

use App\Models\Shops_area;
use Illuminate\Database\Eloquent\Factories\Factory;

class Shops_areaFactory extends Factory
{
    protected $model = Shops_area::class;

    private static $shopId = 0;

    public function definition()
    {
        self::$shopId++;

        return [
            'shop_id' => self::$shopId,
            'area_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}