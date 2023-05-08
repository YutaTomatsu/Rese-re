<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    protected $model = Genre::class;

    public function definition()
    {
        $genreNames = ['寿司', '焼肉', '居酒屋','イタリアン','ラーメン'];

        return [
            'genre_name' => $this->faker->unique()->randomElement($genreNames)
        ];
    }
}