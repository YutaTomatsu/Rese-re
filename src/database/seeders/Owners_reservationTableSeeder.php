<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Owners_reservation;

class Owners_reservationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Owners_reservation::factory()->create([
            'id' => 1,
            'user_id' => 3,
            'shop_id' => 1,
        ]);

        Owners_reservation::factory()->create([
            'id' => 2,
            'user_id' => 3,
            'shop_id' => 2,
        ]);
    }
}