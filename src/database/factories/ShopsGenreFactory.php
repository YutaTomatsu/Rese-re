<?php

namespace Database\Factories;

use App\Models\ShopsGenre;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopsGenreFactory extends Factory
{
    protected $model = ShopsGenre::class;

    private static $shopIds = [
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
        11, 12, 13, 14, 15, 16, 17, 18, 19, 20
    ];

    private static $genreIds = [
        1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5,
        6 => 2, 7 => 4, 8 => 5, 9 => 3, 10 => 1,
        11 => 2, 12 => 2, 13 => 3, 14 => 1, 15 => 5,
        16 => 3, 17 => 1, 18 => 2, 19 => 4, 20 => 1,
    ];

    public function definition()
    {
        $shopId = array_shift(self::$shopIds);
        $genreId = self::$genreIds[$shopId];

        return [
            'shop_id' => $shopId,
            'genre_id' => $genreId,
        ];
    }
}
