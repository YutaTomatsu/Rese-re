<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReserveController extends Controller
{



    public function reserve(Request $request){


        $this->validate($request, [
            'date' => 'required|date',
            'time' => 'required',
            'number_of_people' => 'required|integer',
        ]);

    $is_reserved = Reserve::where([
        ['date', $request->input('date')],
        ['time', $request->input('time')],
    ])->exists();
    if ($is_reserved) {
        return back()->withErrors(['time' => '同時刻に予約済みです。'])->withInput();
    }

        $reserve = new Reserve(); // Reserveモデルのインスタンスを作成する

        // フォームから送信されたデータをモデルにセットする
        $reserve->user_id = Auth::id(); // ログインしているユーザーのIDをセットする
        $reserve->shop_id = $request->input('shop_id');
        $reserve->date = $request->input('date');
        $reserve->time = $request->input('time');
        $reserve->number_of_people = $request->input('number_of_people');

        $reserve->save(); // データをデータベースに保存する

        return view('reserve.done',compact('reserve'));
    }

    public function delete(Request $request)
{
    $reserve_id = $request->input('id');

    $reserve = Reserve::where('id', $reserve_id)->first();

    if ($reserve) {
        $reserve->delete();
    }

    return redirect()->route('mypage');
}


public function edit(Request $request)
{
    $reserve = $request->input('id');
    $reservation = Reserve::where('id', $reserve)->first();
    return view('reserve.reserve_edit', compact('reservation'));
}


public function update(Request $request)
{
       // リクエストデータのバリデーションを行う
        $this->validate($request, [
            'date' => 'required|date',
            'time' => 'required',
            'number_of_people' => 'required|integer',
        ]);

        if (!Auth::check()) {
        return redirect()->route('detail')->with('error', 'ログインしてください。');
    }

    // 同じ日時の予約があるか確認する
    $is_reserved = Reserve::where([
        ['date', $request->input('date')],
        ['time', $request->input('time')],
    ])->exists();
    if ($is_reserved) {
        return back()->withErrors(['time' => '同時刻に予約済みです。']);
    }


    $reservation = Reserve::find($request->input('id'));
    $reservation->date = $request->input('date');
    $reservation->time = $request->input('time');
    $reservation->number_of_people = $request->input('number_of_people');
    $reservation->save();
    return view('reserve.edit_done');
}

public function pastReserves()
{
    $areas=Area::all();
    $genres=Genre::all();

        
         // ショップ情報を取得し、area_name と genre_name を関連付ける
        $pastReserves = Shop::select(
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

    $user = Auth::user();
    $pastReserves = Reserve::
    where('user_id', $user->id)
    ->where(function ($query) {
            $query->where('date', '<', Carbon::today())
                ->orWhere(function ($query) {
                    $query->where('date', '=', Carbon::today())
                        ->where('time', '<', Carbon::now()->format('H:i:s'));
                });
        })
    ->with('shop','shops_area','shops_genre','area','genre')
        ->get();

    return view('reserve.past', compact('areas','genres','pastReserves'));
}

}
