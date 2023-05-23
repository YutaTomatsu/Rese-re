<?php

namespace Database\Factories;

use App\Models\Shops_genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class Shops_genreFactory extends Factory
{
    protected $model = Shops_genre::class;

    private static $shopId = 0;

    public function definition()
    {
        self::$shopId++;

        return [
            'shop_id' => self::$shopId,
            'genre_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
