<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Shop;
use App\Models\Review;
use App\Models\Reserve;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{

    public function create(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user_id = Auth::id();
        $shop_id = $request->input('shop_id');

        $existingReviewsCount = DB::table('reviews')
        ->where('user_id', $user_id)
            ->where('shop_id', $shop_id)
            ->count();

        if ($existingReviewsCount >= 2) {
            return back()->withErrors(['message' => '1店舗に対し口コミは2件までです']);
        }

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

        $favorite_shops = array();
        if (Auth::check()) {
            $favorite_shops = Auth::user()->favorites()->pluck('shop_id')->toArray();
        }

        if ($past_reserves->isEmpty()) {
            return back()->withErrors(['message' => '来店したユーザーのみレビューすることができます']);
        } else {
            return view('review.review', compact('shop_id', 'shop', 'favorite_shops'));
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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = Storage::disk('public')->putFile('review', $image);
            $review->image = $path;
        }

        $review->save();

        return view('review.review_done')->with('success', 'レビューを投稿しました');
    }

    public function destroy($id)
    {
        $review = Review::find($id);
        $review->delete();

        return response()->json(['success' => 'レビューが削除されました。']);
    }

    public function reviewEditForm($id){
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user_id = Auth::id();

        $review = Review::where('id',$id)->first();
        
        $shop_id = $review->shop_id;

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

        $image_filename = basename($review->image); 

        $favorite_shops = array();
        if (Auth::check()) {
            $favorite_shops = Auth::user()->favorites()->pluck('shop_id')->toArray();
        }


        if ($past_reserves->isEmpty()) {
            return back()->withErrors(['message' => '来店したユーザーのみレビューすることができます']);
        } else {
            return view('review.review_edit', compact('shop_id', 'shop', 'favorite_shops','review', 'image_filename'));
        }
    }

    public function reviewEdit(Request $request,$id)
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
        $review = Review::where('id',$id)->first();
        $review->user_id = $user_id;
        $review->shop_id = $shop_id;
        $review->evaluate = $validatedData['evaluate'];
        $review->comment = $validatedData['comment'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = Storage::disk('public')->putFile('review', $image);
            $review->image = $path;
        }

        $review->save();

        return view('review.review_done')->with('success', 'レビューを編集しました');
    }


}
