<?php

namespace Database\Seeders;

use App\Models\Cource;
use Illuminate\Database\Seeder;

class CourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cource::factory()->create();
    }
}
