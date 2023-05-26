<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Review::factory()->create([
            'id' => 21,
            'user_id' => rand(4, 20),
            'shop_id' => 1,
            'comment' => 'とても美味しかったです！',
            'evaluate' => 5,
        ]);

        Review::factory()->create([
            'id' => 22,
            'user_id' => rand(4, 20),
            'shop_id' => 1,
            'comment' => '100000円コースを食べてみました。流石に100000円は高いです、、。今後に期待して星2で。',
            'evaluate' => 2,
        ]);

        Review::factory()->create([
            'id' => 23,
            'user_id' => rand(4, 20),
            'shop_id' => 1,
            'comment' => '100000円は高い。',
            'evaluate' => 1,
        ]);

        Review::factory()->create([
            'id' => 24,
            'user_id' => rand(4, 20),
            'shop_id' => 1,
            'comment' => '1000円コースを食べました！100000円コースと比較したら劣りますがお値段以上だと思いました。。',
            'evaluate' => 4,
        ]);

        Review::factory()->create([
            'id' => 25,
            'user_id' => rand(4, 20),
            'shop_id' => 1,
            'comment' => 'リピします。',
            'evaluate' => 5,
        ]);
    }
}
