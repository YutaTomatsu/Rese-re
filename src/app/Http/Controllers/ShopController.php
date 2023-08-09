<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;

class ShopController extends Controller
{
    public function index()
    {

        $areas = Area::all();
        $genres = Genre::all();

        $shops = Shop::select(
            'shops.id as shop_id',
            'shops.name',
            'shops.picture',
            'areas.area_name',
            'genres.genre_name'
        )
            ->leftJoin('shops_areas', 'shops.id', '=', 'shops_areas.shop_id')
            ->leftJoin('areas', 'shops_areas.area_id', '=', 'areas.id')
            ->leftJoin('shops_genres', 'shops.id', '=', 'shops_genres.shop_id')
            ->leftJoin('genres', 'shops_genres.genre_id', '=', 'genres.id')
            ->get();

        $favorite_shops = array();
        if (Auth::check()) {
            $favorite_shops = Auth::user()->favoriteShops()->pluck('shop_id')->toArray();
        }

        $reviewsAvg = array();
        foreach ($shops as $shop) {
            $shop_reviews = \DB::table('reviews')->where('shop_id', $shop->shop_id)->get();
            $shop->reviewsAvg = $shop_reviews->avg('evaluate');
        }

        return view('welcome', compact('shops', 'areas', 'genres', 'favorite_shops', 'reviewsAvg'));
    }
}
