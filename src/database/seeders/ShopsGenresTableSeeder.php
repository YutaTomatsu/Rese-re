<?php

namespace Database\Seeders;

use App\Models\Shop_genre;
use Illuminate\Database\Seeder;

class ShopsGenresTableSeeder extends Seeder
{
    public function run()
    {
        Shop_genre::factory()->count(5)->create();
    }
}