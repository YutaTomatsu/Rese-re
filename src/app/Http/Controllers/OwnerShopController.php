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
use App\Models\Shops_area;
use App\Models\Shops_genre;
use App\Models\Owners_reservation;
use Illuminate\Support\Facades\Auth;


class OwnerShopController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        $areas=Area::all();
        $genres=Genre::all();
        return view('owner.owner-create',compact('areas','genres'));
    }
    


    public function store(Request $request)
    {
        // バリデーションチェック
         $this->validate($request, [
        'name' => 'required|string|max:255',
        'about' => 'required|string',
        'picture' => 'required|image',
        'area_id' => 'required|exists:areas,id',
        'genre_id' => 'required|exists:genres,id'
    ], [
        'name.required' => '店名を入力してください。',
        'about.required' => '店舗紹介文を入力してください。',
        'picture.required' => '画像を選択してください。',
        'picture.image' => '画像ファイルを選択してください。',
        'area_id.required' => 'エリアを選択してください。',
        'area_id.exists' => '選択されたエリアが存在しません。',
        'genre_id.required' => 'ジャンルを選択してください。',
        'genre_id.exists' => '選択されたジャンルが存在しません。'
    ]);

    


        $path = Storage::putFile('public/shops', new File($request->file('picture')));

        // Shopモデルを作成して保存する
        $shop = new Shop();
        $shop->name = $request->input('name');
        $shop->about = $request->input('about');
        $shop->picture = $path; // 保存する画像のパスを指定する
        $shop->save();

       $shop_area = new Shops_area();
$shop_area->shop_id = $shop->id; // 自動生成された ID をセットする
$shop_area->area_id = $request->input('area_id');
$shop_area->save();


        $shop_genre = new Shops_genre();
$shop_genre->shop_id = $shop->id; // 自動生成された ID をセットする
$shop_genre->genre_id = $request->input('genre_id');
$shop_genre->save();

// owners_reservationsテーブルに保存する
    $ownerReservation = new Owners_reservation();
    $ownerReservation->user_id = Auth::user()->id; // ログインしているユーザーのIDをセットする
    $ownerReservation->shop_id = $shop->id; // 作成された店舗のIDをセットする
    $ownerReservation->save();


        return redirect()->back()->with('success', 'ショップが登録されました！');
    }

    
    public function edit($id)
{
$shop = Shop::findOrFail($id);
$areas = Area::all();
$genres = Genre::all();

return view('owner.owner-edit', compact('shop', 'areas', 'genres'));
}

public function update(Request $request, $id)
{
// バリデーションチェック
$this->validate($request, [
'name' => 'required|string|max:255',
'about' => 'required|string',
'picture' => 'image',
'area_id' => 'required|exists:areas,id',
'genre_id' => 'required|exists:genres,id'
], [
'name.required' => '店名を入力してください。',
'about.required' => '店舗紹介文を入力してください。',
'picture.image' => '画像ファイルを選択してください。',
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
    // 画像ファイルがアップロードされた場合は、画像を保存する
    $path = Storage::putFile('public/shops', new File($request->file('picture')));
    $shop->picture = $path;
}
$shop->save();

return redirect()->back()->with('success', 'ショップが更新されました！');
}
}