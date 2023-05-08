<?php

namespace Database\Seeders;

use App\Models\Shops_genre;
use Illuminate\Database\Seeder;

class Shops_genreTableSeeder extends Seeder
{
    public function run()
    {
        Shops_genre::factory()->count(20)->create();
    }
}