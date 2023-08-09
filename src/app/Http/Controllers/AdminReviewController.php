<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Review;
use App\Models\Cource;

class AdminReviewController extends Controller
{
    public function showShop(){
        $areas = Area::all();
        $genres = Genre::all();
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

        $favorite_shops = array();
        if (Auth::check()) {
            $favorite_shops = Auth::user()->favorites()->pluck('shop_id')->toArray();
        }

        $reviewsAvg = array();
        foreach ($shops as $shop) {
            $shop_reviews = \DB::table('reviews')->where('shop_id', $shop->shop_id)->get();
            $shop->reviewsAvg = $shop_reviews->avg('evaluate');
        }

        return view('admin.shop_all', compact('shops', 'areas', 'genres', 'favorite_shops', 'reviewsAvg'));
    }

    public function showReview(Request $request){
        $id = $request->input('id');
        $sortOption = $request->input('sort', 'new');

        $query = Review::with('user')->where('shop_id', $id);

        switch ($sortOption) {
            case 'high':
                $query->orderBy('evaluate', 'desc');
                break;
            case 'low':
                $query->orderBy('evaluate', 'asc');
                break;
            case 'new':
                $query->orderBy('created_at', 'desc');
                break;
            case 'old':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $totalReviews = Review::where('shop_id', $id)->count();
        $reviewsAvg = Review::where('shop_id', $id)->avg('evaluate');
        $reviews = $query->paginate(10);
        $shop = Shop::select('shops.id', 'name', 'picture', 'areas.area_name', 'genres.genre_name', 'about')
            ->leftJoin('shops_areas', 'shops.id', '=', 'shops_areas.shop_id')
            ->leftJoin('areas', 'shops_areas.area_id', '=', 'areas.id')
            ->leftJoin('shops_genres', 'shops.id', '=', 'shops_genres.shop_id')
            ->leftJoin('genres', 'shops_genres.genre_id', '=', 'genres.id')
            ->where('shops.id', $id)
            ->firstOrFail();

        $cources = Cource::where('shop_id', $id)->first();

        if (!$cources) {
            $cources = null;
        }

        return view('admin.shop_review', compact('id', 'shop', 'reviews', 'reviewsAvg', 'totalReviews', 'sortOption', 'cources'));
    }

    public function reviewSorting(Request $request, $id)
    {
        $sortOption = $request->input('sort', 'new');

        $query = Review::with('user')->where('shop_id', $id);

        switch ($sortOption) {
            case 'high':
                $query->orderBy('evaluate', 'desc');
                break;
            case 'low':
                $query->orderBy('evaluate', 'asc');
                break;
            case 'new':
                $query->orderBy('created_at', 'desc');
                break;
            case 'old':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $totalReviews = Review::where('shop_id', $id)->count();
        $reviewsAvg = Review::where('shop_id', $id)->avg('evaluate');
        $reviews = $query->paginate(10);
        $shop = Shop::select('shops.id', 'name', 'picture', 'areas.area_name', 'genres.genre_name', 'about')
        ->leftJoin('shops_areas', 'shops.id', '=', 'shops_areas.shop_id')
        ->leftJoin('areas', 'shops_areas.area_id', '=', 'areas.id')
        ->leftJoin('shops_genres', 'shops.id', '=', 'shops_genres.shop_id')
        ->leftJoin('genres', 'shops_genres.genre_id', '=', 'genres.id')
        ->where('shops.id', $id)
            ->firstOrFail();
        $cources = Cource::where('shop_id', $id)->first();

        if (!$cources) {
            $cources = null;
        }

        return view('admin.shop_review', compact('id', 'shop', 'reviews', 'reviewsAvg', 'totalReviews', 'sortOption', 'cources'));
    }
}
