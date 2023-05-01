<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

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