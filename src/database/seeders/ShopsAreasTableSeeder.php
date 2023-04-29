<?php

namespace Database\Seeders;

use App\Models\Shop_area;
use Illuminate\Database\Seeder;

class ShopsAreasTableSeeder extends Seeder
{
    public function run()
    {
        Shop_area::factory()->count(5)->create();
    }
}