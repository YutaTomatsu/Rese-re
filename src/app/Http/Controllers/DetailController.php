<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Review;
use App\Models\Cource;

class DetailController extends Controller
{
    public function index(Request $request)
    {
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

        return view('detail', compact('id', 'shop', 'reviews', 'reviewsAvg', 'totalReviews', 'sortOption', 'cources'));
    }

    public function reviewSort(Request $request, $id)
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

        return view('detail', compact('id', 'shop', 'reviews', 'reviewsAvg', 'totalReviews', 'sortOption', 'cources'));
    }
}
