<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Review;
use App\Models\Reserve;
use Carbon\Carbon;

class OwnerReservationController extends Controller
{

    public function index(Request $request)
{

    $id =$request->input('id');
    $shop = Shop::select('name', 'picture', 'areas.area_name', 'genres.genre_name', 'about')
        ->leftJoin('shops_areas', 'shops.id', '=', 'shops_areas.shop_id')
        ->leftJoin('areas', 'shops_areas.area_id', '=', 'areas.id')
        ->leftJoin('shops_genres', 'shops.id', '=', 'shops_genres.shop_id')
        ->leftJoin('genres', 'shops_genres.genre_id', '=', 'genres.id')
        ->where('shops.id', $id)
        ->firstOrFail();

        $query_params = $request->query();
    $reserves_query = Reserve::query();

    $date = request()->query('date', date('Y-m-d'));
        $prev_date = Carbon::parse($date)->subDay()->toDateString();
        $next_date = Carbon::parse($date)->addDay()->toDateString();
    
        $reserves = Reserve::join('users', 'reserves.user_id', '=', 'users.id')
    ->where('reserves.shop_id', $id)
    ->where('reserves.date', $date)
    ->paginate(1, ['*'], 'reserve-page');
        $reserves_paginator = $reserves->appends($query_params);

        $reserves->appends(['date' => $date])->links();



        return view('owner.owner-reserve', compact('id','shop','reserves', 'reserves_paginator', 'query_params','date','prev_date','next_date'));
}

public function date(Request $request, $id, $date)
{
    $shop = Shop::select('name', 'picture', 'areas.area_name', 'genres.genre_name', 'about')
        ->leftJoin('shops_areas', 'shops.id', '=', 'shops_areas.shop_id')
        ->leftJoin('areas', 'shops_areas.area_id', '=', 'areas.id')
        ->leftJoin('shops_genres', 'shops.id', '=', 'shops_genres.shop_id')
        ->leftJoin('genres', 'shops_genres.genre_id', '=', 'genres.id')
        ->where('shops.id', $id)
        ->firstOrFail();

    $query_params = $request->query();

    $date = Carbon::parse($date)->toDateString(); // 渡された日付を変換

    $prev_date = Carbon::parse($date)->subDay()->toDateString();
    $next_date = Carbon::parse($date)->addDay()->toDateString();

    $reserves = Reserve::join('users', 'reserves.user_id', '=', 'users.id')
        ->where('reserves.shop_id', $id)
        ->whereDate('reserves.date', $date) // 日付の条件を変更
        ->paginate();
    $reserves_paginator = $reserves->appends($query_params);

    $reserves->appends(['date' => $date])->links();

    return view('owner.owner-reserve', compact('id', 'shop', 'reserves', 'reserves_paginator', 'query_params', 'date', 'prev_date', 'next_date'));
}



}
