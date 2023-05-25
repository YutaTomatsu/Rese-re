<?php

namespace Database\Factories;

use App\Models\ShopsArea;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopsAreaFactory extends Factory
{
    protected $model = ShopsArea::class;

    private static $shopIds = [
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
        11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
    ];

    private static $areaIds = [
        1 => 1, 2 => 2, 3 => 3, 4 => 1, 5 => 3,
        6 => 1, 7 => 2, 8 => 1, 9 => 2, 10 => 1,
        11 => 2, 12 => 3, 13 => 1, 14 => 2, 15 => 1,
        16 => 2, 17 => 1, 18 => 1, 19 => 3, 20 => 2,
    ];

    public function definition()
    {
        $shopId = array_shift(self::$shopIds);
        $areaId = self::$areaIds[$shopId];

        return [
            'shop_id' => $shopId,
            'area_id' => $areaId,
        ];
    }
}
