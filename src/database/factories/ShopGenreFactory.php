<?php

namespace Database\Factories;

use App\Models\ShopGenre;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopGenreFactory extends Factory
{
    protected $model = ShopGenre::class;

    private static $shopIds = null;
    private static $genreIds = [1, 2, 3];

    public function definition()
    {
        if (self::$shopIds === null) {
            self::$shopIds = collect([1, 2, 3, 4, 5])->shuffle();
        }

        return [
            'shop_id' => self::$shopIds->pop(),
            'genre_id' => $this->faker->randomElement(self::$genreIds)
        ];
    }
}