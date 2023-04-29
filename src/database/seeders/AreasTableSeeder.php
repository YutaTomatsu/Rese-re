<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    public function run()
    {
        Area::factory()->count(5)->create();
    }
}
