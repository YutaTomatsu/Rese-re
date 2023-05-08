<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */



    public function definition()
    {
        $shopIds = range(1, 20);
        shuffle($shopIds);
        $shopId = array_pop($shopIds);

        $userIds = range(1, 20);
        shuffle($userIds);
        $userId = array_pop($userIds);

        $comment = 
            'ここにコメントが表示されます';

        return [
            'user_id' => $userId,
            'shop_id' => $shopId,
            'comment' => $comment, 
            'evaluate' => $this->faker->numberBetween(1, 5),
        ];
    }
}
