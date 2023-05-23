<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    protected $model = Genre::class;

    private $genres = [
        ['id' => 1, 'genre_name' => '寿司'],
        ['id' => 2, 'genre_name' => '焼肉'],
        ['id' => 3, 'genre_name' => '居酒屋'],
        ['id' => 4, 'genre_name' => 'イタリアン'],
        ['id' => 5, 'genre_name' => 'ラーメン'],
    ];

    public function definition()
    {
        $genre = array_shift($this->genres);

        return [
            'id' => $genre['id'],
            'genre_name' => $genre['genre_name'],
        ];
    }
}
