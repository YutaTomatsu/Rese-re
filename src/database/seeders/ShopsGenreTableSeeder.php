<?php

namespace Database\Seeders;

use App\Models\ShopsGenre;
use Illuminate\Database\Seeder;

class ShopsGenreTableSeeder extends Seeder
{
    public function run()
    {
        ShopsGenre::factory()->count(20)->create();
    }
}