<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Shop;
use App\Models\Review;
use App\Models\Reserve;

class ReviewController extends Controller
{



    public function create(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user_id = Auth::id();
        $shop_id = $request->input('shop_id');

        $shop = Shop::select('name', 'picture', 'areas.area_name', 'genres.genre_name', 'about')
            ->leftJoin('shops_areas', 'shops.id', '=', 'shops_areas.shop_id')
            ->leftJoin('areas', 'shops_areas.area_id', '=', 'areas.id')
            ->leftJoin('shops_genres', 'shops.id', '=', 'shops_genres.shop_id')
            ->leftJoin('genres', 'shops_genres.genre_id', '=', 'genres.id')
            ->where('shops.id', $shop_id)
            ->firstOrFail();

        $past_reserves = Reserve::where('user_id', $user_id)
            ->where('shop_id', $shop_id)
            ->where(function ($query) {
                $query->where('date', '<', Carbon::today())
                    ->orWhere(function ($query) {
                        $query->where('date', '=', Carbon::today())
                            ->where('time', '<', Carbon::now()->format('H:i:s'));
                    });
            })
            ->get();


        if ($past_reserves->isEmpty()) {
            return back()->withErrors(['message' => '来店したユーザーのみレビューすることができます']);
        } else {
            return view('review.review', compact('shop_id', 'shop'));
        }
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'evaluate' => 'required',
                'comment' => 'required|string|max:255',
            ],
            [
                'evaluate.required' => '評価は必須項目です。',
                'comment.required' => 'コメントは必須項目です。',
                'comment.string' => 'コメントは文字列で入力してください。',
                'comment.max' => 'コメントは255文字以内で入力してください。',
            ]
        );

        $shop_id = $request->input('shop_id');
        $user_id = Auth::id();
        $review = new Review();
        $review->user_id = $user_id;
        $review->shop_id = $shop_id;
        $review->evaluate = $validatedData['evaluate'];
        $review->comment = $validatedData['comment'];
        $review->save();

        return view('review.review-done')->with('success', 'レビューを投稿しました');
    }
}
