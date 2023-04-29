<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(5)->create();
        \App\Models\Shop::factory(5)->create();
        \App\Models\Area::factory(5)->create();
        \App\Models\Genre::factory(5)->create();
        \App\Models\Shop_area::factory(5)->create();
        \App\Models\Shop_genre::factory(5)->create();
        
    }
}
