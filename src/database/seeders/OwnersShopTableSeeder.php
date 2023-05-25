<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OwnersShop;

class OwnersShopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OwnersShop::factory()->create([
            'id' => 1,
            'user_id' => 3,
            'shop_id' => 1,
        ]);

        OwnersShop::factory()->create([
            'id' => 2,
            'user_id' => 3,
            'shop_id' => 2,
        ]);
    }
}