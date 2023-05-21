<?php

namespace Database\Factories;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    protected $model = Area::class;

    private $areas = [
        ['id' => 1, 'area_name' => '東京都'],
        ['id' => 2, 'area_name' => '大阪府'],
        ['id' => 3, 'area_name' => '福岡県'],
    ];

    public function definition()
    {
        $area = array_shift($this->areas);

        return [
            'id' => $area['id'],
            'area_name' => $area['area_name'],
        ];
    }
}
