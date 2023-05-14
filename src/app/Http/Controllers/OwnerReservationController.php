<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Review;
use App\Models\Reserve;




class OwnerReservationController extends Controller
{



    public function index(Request $request)
{

    $id =$request->input('id');
    $reviews = Review::with('user')->where('shop_id', $id)->orderBy('created_at', 'desc')->Paginate(5, ["*"], 'review-page');
    $totalReviews = Review::where('shop_id', $id)->count();
    $reviewsAvg = Review::where('shop_id', $id)->avg('evaluate');
    $shop = Shop::select('name', 'picture', 'areas.area_name', 'genres.genre_name', 'about')
        ->leftJoin('shops_areas', 'shops.id', '=', 'shops_areas.shop_id')
        ->leftJoin('areas', 'shops_areas.area_id', '=', 'areas.id')
        ->leftJoin('shops_genres', 'shops.id', '=', 'shops_genres.shop_id')
        ->leftJoin('genres', 'shops_genres.genre_id', '=', 'genres.id')
        ->where('shops.id', $id)
        ->firstOrFail();

        $query_params = $request->query();
    $reserves_query = Reserve::query();


    
        $reserves = Reserve::join('users', 'reserves.user_id', '=', 'users.id')
    ->where('reserves.shop_id', $id)
    ->paginate(5, ['*'], 'reserve-page');
        $reserves_paginator = $reserves->appends($query_params);



        return view('owner.owner-reserve', compact('shop','reviews','reserves','reviewsAvg', 'totalReviews', 'reserves_paginator', 'query_params'));
}

}
