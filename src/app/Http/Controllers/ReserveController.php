<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use Illuminate\Support\Facades\Auth;

class ReserveController extends Controller
{
    public function reserve(Request $request){

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

        $reserve = new Reserve(); // Reserveモデルのインスタンスを作成する

        // フォームから送信されたデータをモデルにセットする
        $reserve->user_id = Auth::id(); // ログインしているユーザーのIDをセットする
        $reserve->shop_id = $request->input('shop_id');
        $reserve->date = $request->input('date');
        $reserve->time = $request->input('time');
        $reserve->number_of_people = $request->input('number_of_people');

        $reserve->save(); // データをデータベースに保存する

        return view('reserve.done');
    }
}
