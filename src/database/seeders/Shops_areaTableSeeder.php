<?php

namespace Database\Seeders;

use App\Models\Shops_area;
use Illuminate\Database\Seeder;

class Shops_areaTableSeeder extends Seeder
{
     public function run()
    {
        Shops_area::factory()->count(20)->create();
    }
}