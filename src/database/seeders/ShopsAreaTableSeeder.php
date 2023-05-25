<?php

namespace Database\Seeders;

use App\Models\ShopsArea;
use Illuminate\Database\Seeder;

class ShopsAreaTableSeeder extends Seeder
{
     public function run()
    {
        ShopsArea::factory()->count(20)->create();
    }
}