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
        \App\Models\User::factory(20)->create();
        \App\Models\Admin::factory(2)->create();
        \App\Models\Shop::factory(20)->create();
        \App\Models\Area::factory(3)->create();
        \App\Models\Genre::factory(5)->create();
        \App\Models\Shops_area::factory(20)->create();
        \App\Models\Shops_genre::factory(20)->create();
        \App\Models\Review::factory(20)->create();
        $this->call([CourcesTableSeeder::class,]);
        
    }
}
