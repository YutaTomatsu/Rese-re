<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Reserve;
use App\Models\Favorite;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Reserves_cource;

class MypageController extends Controller
{
    public function mypage()
    {
        $user_id = auth()->id();

        $reservations = Reserve::where('user_id', $user_id)->get();
        $favorites = Favorite::where('user_id', $user_id)->get();

        $areas = Area::all();
        $genres = Genre::all();

        $favorite_shops = array();
        if (Auth::check()) {
            $favorite_shops = Auth::user()->favorites()->pluck('shop_id')->toArray();
        }

        $cources = Reserves_cource::whereIn('reserve_id', $reservations->pluck('id'))->get();

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
            ->whereIn('shops.id', $favorite_shops)
            ->get();

        return view('mypage.mypage', compact('reservations', 'cources', 'shops', 'areas', 'genres', 'favorite_shops'));
    }
}
