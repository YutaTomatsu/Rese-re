<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\ShopsArea;
use App\Models\ShopsGenre;
use App\Models\OwnersShop;
use Illuminate\Support\Facades\Auth;


class OwnerShopController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        $areas = Area::all();
        $genres = Genre::all();
        return view('owner.owner_create', compact('areas', 'genres'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'about' => 'required|string|max:255',
            'picture' => 'required|image|max:2048',
            'area_id' => 'required|exists:areas,id',
            'genre_id' => 'required|exists:genres,id'
        ], [
            'name.required' => '店名を入力してください。',
            'name.max' => '店名は50文字以内で入力してください。',
            'name.max' => '店舗紹介文は255文字以内で入力してください。',
            'about.required' => '店舗紹介文を入力してください。',
            'about.max' => '店舗紹介文は255文字以内で入力してください。',
            'picture.required' => '画像を選択してください。',
            'picture.image' => '画像ファイルを選択してください。',
            'picture.max' => '画像サイズが大きすぎます。最大2MBまでの画像を選択してください。',
            'area_id.required' => 'エリアを選択してください。',
            'area_id.exists' => '選択されたエリアが存在しません。',
            'genre_id.required' => 'ジャンルを選択してください。',
            'genre_id.exists' => '選択されたジャンルが存在しません。'
        ]);

        if ($request->hasFile('picture')) {
            $fileSize = $request->file('picture')->getSize();
            $maxFileSize = 2048 * 1024;

            if ($fileSize > $maxFileSize) {

                return redirect()->back()->withErrors(['picture' => '画像サイズが大きすぎます。最大2MBまでの画像を選択してください。'])->withInput();
            }
        }

        $path = Storage::disk('s3')->putFile('shops', new File($request->file('picture')));

        $shop = new Shop();
        $shop->name = $request->input('name');
        $shop->about = $request->input('about');
        $shop->picture = Storage::disk('s3')->url($path);
        $shop->save();

        $shop_area = new ShopsArea();
        $shop_area->shop_id = $shop->id;
        $shop_area->area_id = $request->input('area_id');
        $shop_area->save();


        $shop_genre = new ShopsGenre();
        $shop_genre->shop_id = $shop->id;
        $shop_genre->genre_id = $request->input('genre_id');
        $shop_genre->save();

        $ownerReservation = new OwnersShop();
        $ownerReservation->user_id = Auth::user()->id;
        $ownerReservation->shop_id = $shop->id;
        $ownerReservation->save();

        return redirect()->back()->with('success', 'ショップが登録されました！');
    }


    public function edit($id)
    {
        $shop = Shop::select('shops.id', 'name', 'picture', 'shops_areas.area_id', 'areas.area_name', 'shops_genres.genre_id', 'genres.genre_name', 'about')
            ->leftJoin('shops_areas', 'shops.id', '=', 'shops_areas.shop_id')
            ->leftJoin('areas', 'shops_areas.area_id', '=', 'areas.id')
            ->leftJoin('shops_genres', 'shops.id', '=', 'shops_genres.shop_id')
            ->leftJoin('genres', 'shops_genres.genre_id', '=', 'genres.id')
            ->where('shops.id', $id)
            ->firstOrFail();
        $areas = Area::all();
        $genres = Genre::all();

        return view('owner.owner_edit', compact('shop', 'areas', 'genres'));
    }




    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'about' => 'required|string|max:255',
            'picture' => 'required|image|max:2048',
            'area_id' => 'required|exists:areas,id',
            'genre_id' => 'required|exists:genres,id'
        ], [
            'name.required' => '店名を入力してください。',
            'name.max' => '店名は50文字以内で入力してください。',
            'name.max' => '店舗紹介文は255文字以内で入力してください。',
            'about.required' => '店舗紹介文を入力してください。',
            'about.max' => '店舗紹介文は255文字以内で入力してください。',
            'picture.required' => '画像を選択してください。',
            'picture.image' => '画像ファイルを選択してください。',
            'picture.max' => '画像サイズが大きすぎます。最大2MBまでの画像を選択してください。',
            'area_id.required' => 'エリアを選択してください。',
            'area_id.exists' => '選択されたエリアが存在しません。',
            'genre_id.required' => 'ジャンルを選択してください。',
            'genre_id.exists' => '選択されたジャンルが存在しません。'
        ]);

        $shop = Shop::findOrFail($id);

        $shop->name = $request->input('name');
        $shop->about = $request->input('about');
        $shop->shops_areas()->sync([$request->input('area_id')]);
        $shop->shops_genres()->sync([$request->input('genre_id')]);


        if ($request->hasFile('picture')) {
            $path = Storage::disk('s3')->putFile('shops', new File($request->file('picture')));
            $shop->picture = Storage::disk('s3')->url($path);
        }
        $shop->save();

        return redirect()->back()->with('success', 'ショップが更新されました！');
    }
}
