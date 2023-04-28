<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;


class ShopController extends Controller
{


    public function index()
    {

        $areas=Area::all();
        $genres=Genre::all();

        
         // ショップ情報を取得し、area_name と genre_name を関連付ける
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

        return view('welcome', compact('shops','areas','genres'));
    }
}
