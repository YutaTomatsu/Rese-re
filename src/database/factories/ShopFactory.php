<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopFactory extends Factory
{
    protected $model = Shop::class;

    public function definition()
    {
        $pictureUrls = [
            'https://rese-bucket.s3.ap-northeast-1.amazonaws.com/public/shops/AXWY9zzkB3YOYyckGkLK7SvMLhtNFdFXXoCaZ8nk.jpg',
            'https://rese-bucket.s3.ap-northeast-1.amazonaws.com/shops/oCOdlZ8TZPo3ma8gsGFbU9srePSnIQvYMieSYQ1O.jpg',
            'https://rese-bucket.s3.ap-northeast-1.amazonaws.com/shops/UacF9GLnzgQqmYLfltPzfUxCf2Yq7Sm92VIXZRvQ.jpg',
            'https://rese-bucket.s3.ap-northeast-1.amazonaws.com/shops/R0q2nyBo3oOiYdlxIBEo1VUVOpGWxHh1KG2Ewcqd.jpg',
            'https://rese-bucket.s3.ap-northeast-1.amazonaws.com/shops/kdirpe4iHdmRTsZRFqCbYuf1QUkelDf8ZqOzC0dw.jpg',
        ];


        return [
            'name' => $this->faker->company(),
            'about' => $this->faker->sentence(20),
            'picture' => $this->faker->randomElement($pictureUrls),
        ];
    }
}