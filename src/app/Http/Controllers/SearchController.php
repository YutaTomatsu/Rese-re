<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;

class SearchController extends Controller
{
    public function search(Request $request)
{
  $area_name = $request->input('area_name');
  $genre_name = $request->input('genre_name');
  $name = $request->input('name');

  $shops = Shop::query();
  $areas = Area::all();
  $genres = Genre::all();

if ($area_name) {
            $shops->whereHas('areas', function ($query) use ($area_name) {
                $query->where('areas.area_name', $area_name);
            });
        }
        if ($genre_name) {
            $shops->whereHas('genres', function ($query) use ($genre_name) {
                $query->where('genres.genre_name', $genre_name);
            });
        }
  if ($name) {
    $shops->where('name', 'like', '%' . $name . '%');
  }

  $shops = $shops->leftJoin('shops_areas', 'shops.id', '=', 'shops_areas.shop_id')
            ->leftJoin('areas', 'shops_areas.area_id', '=', 'areas.id')
            ->leftJoin('shops_genres', 'shops.id', '=', 'shops_genres.shop_id')
            ->leftJoin('genres', 'shops_genres.genre_id', '=', 'genres.id')
            ->get();


  return view('welcome', compact('shops','areas','genres'));
}
}
