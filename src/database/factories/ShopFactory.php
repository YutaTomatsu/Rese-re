<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopFactory extends Factory
{
    protected $model = Shop::class;

    public function definition()
    {
        $pictureUrls = [
            'public/shops/sushi.jpeg',
            'public/shops/izakaya.jpeg',
            'public/shops/yakiniku.jpeg',
            'public/shops/italian.jpeg',
            'public/shops/ramen.jpeg',
        ];


        return [
            'name' => $this->faker->company(),
            'about' => $this->faker->sentence(20),
            'picture' => $this->faker->randomElement($pictureUrls),
        ];
    }
}