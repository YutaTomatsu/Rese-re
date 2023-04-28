<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{


    public function store(Request $request)
{
    $shop_id = $request->input('shop_id');
    $user_id = $request->user()->id ?? null;

    if ($user_id && !Favorite::where('shop_id', $shop_id)->where('user_id', $user_id)->exists()) {
        Favorite::create([
            'shop_id' => $shop_id,
            'user_id' => $user_id,
        ]);
    }

    return response()->json(['message' => 'Added to favorites']);
}

public function destroy(Request $request)
{
    $shop_id = $request->input('shop_id');
    $user_id = auth()->id() ?? null;

    if ($user_id && Favorite::where('shop_id', $shop_id)->where('user_id', $user_id)->exists()) {
        $favorite = Favorite::where('shop_id', $shop_id)->where('user_id', $user_id)->firstOrFail();
        $favorite->delete();

        return response()->json(['message' => 'Removed from favorites']);
    }

    return response()->json(['message' => 'Favorite not found']);
}


public function like(Request $request)
{
    $user_id = Auth::user()->id; //1.ログインユーザーのid取得
    $shop_id = $request->input('shop_id'); // request から input() で取得するよう修正
    $already_favorited = Favorite::where('user_id', $user_id)->where('shop_id', $shop_id)->first();

    if (!$already_favorited) { //もしこのユーザーがこの投稿にまだいいねしてなかったら
        $favorite = new Favorite; // Like から Favorite に修正
        $favorite->shop_id = $shop_id;
        $favorite->user_id = $user_id;
        $favorite->save();
    } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete
       $already_favorited->delete();
    }
    return response()->json($param); //6.JSONデータをjQueryに返す
}



public function toggle(Request $request)
{
    $user_id = Auth::id();
    $shop_id = $request->input('shop_id');
    $already_favorited = Favorite::where('user_id', $user_id)->where('shop_id', $shop_id)->first();

    if (!$already_favorited) {
        $favorite = new Favorite;
        $favorite->shop_id = $shop_id;
        $favorite->user_id = $user_id;
        $favorite->save();
        $status = 'favorited'; // レスポンスに送信するステータスを設定
    } else {
        $already_favorited->delete();
        $status = 'unfavorited'; // レスポンスに送信するステータスを設定
    }

    $param = ['status' => $status]; // レスポンスの内容を配列に設定
    return response()->json(['status' => $status]);
}


public function favorite(Request $request)
{
    $shop_id = $request->input('shop_id');
    $user_id = Auth::id();

    $favorite = Favorite::where('shop_id', $shop_id)->where('user_id', $user_id)->first();

    if ($favorite) {
        $favorite->delete();
        return response()->json(['status' => 'success', 'message' => 'お気に入りを解除しました']);
    } else {
        $favorite = new Favorite();
        $favorite->shop_id = $shop_id;
        $favorite->user_id = $user_id;
        $favorite->save();
        return response()->json(['status' => 'success', 'message' => 'お気に入りに追加しました']);
    }
}



}