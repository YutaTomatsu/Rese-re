<?php

namespace Database\Factories;

use App\Models\ShopArea;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopAreaFactory extends Factory
{
    protected $model = ShopArea::class;

    private static $shopIds = null;
    private static $areaIds = [1, 2, 3];

    public function definition()
    {
        if (self::$shopIds === null) {
            self::$shopIds = collect([1, 2, 3, 4, 5])->shuffle();
        }

        return [
            'shop_id' => self::$shopIds->pop(),
            'area_id' => $this->faker->randomElement(self::$areaIds)
        ];
    }
}