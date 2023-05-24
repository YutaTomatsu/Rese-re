<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Review;

class OwnerReviewController extends Controller
{
    public function index(Request $request)
    {

        $id = $request->input('id');
        $reviews = Review::with('user')->where('shop_id', $id)->orderBy('created_at', 'desc')->Paginate(10, ["*"], 'review-page');
        $totalReviews = Review::where('shop_id', $id)->count();
        $reviewsAvg = Review::where('shop_id', $id)->avg('evaluate');
        $shop = Shop::select('name', 'picture', 'areas.area_name', 'genres.genre_name', 'about')
            ->leftJoin('shops_areas', 'shops.id', '=', 'shops_areas.shop_id')
            ->leftJoin('areas', 'shops_areas.area_id', '=', 'areas.id')
            ->leftJoin('shops_genres', 'shops.id', '=', 'shops_genres.shop_id')
            ->leftJoin('genres', 'shops_genres.genre_id', '=', 'genres.id')
            ->where('shops.id', $id)
            ->firstOrFail();

        return view('owner.owner-review', compact('shop', 'reviews', 'reviewsAvg', 'totalReviews'));
    }
}
