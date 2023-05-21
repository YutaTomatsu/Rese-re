<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\Models\Reserve;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class ReserveController extends Controller
{



    public function reserve(Request $request){

        if (!Auth::check()) {
        return redirect()->route('login');
    }


        $this->validate($request, [
            'date' => 'required|date',
            'time' => 'required',
            'number_of_people' => 'required|integer',
        ], [
        'date.required' => '日付を入力してください。',
        'date.date' => '日付の形式が無効です。',
        'time.required' => '時間を入力してください。',
        'number_of_people.required' => '人数を入力してください。',
        'number_of_people.integer' => '人数は整数で入力してください。',
    ]);



   $is_reserved = Reserve::where([
    ['user_id', Auth::id()],
    ['date', $request->input('date')],
    ['time', $request->input('time')],
])->exists();

if ($is_reserved) {
    return back()->withErrors(['time' => '同時刻に予約済みです。'])->withInput();
}



        $reserve = new Reserve(); // Reserveモデルのインスタンスを作成する

        // フォームから送信されたデータをモデルにセットする
        $reserve->user_id = Auth::id(); // ログインしているユーザーのIDをセットする
        $reserve->shop_id = $request->input('shop_id');
        $reserve->date = $request->input('date');
        $reserve->time = $request->input('time');
        $reserve->number_of_people = $request->input('number_of_people');

if ($request->filled('cource')) {
    // courceが選択されている場合はpayment.blade.phpに渡す
    $reserve->cource = $request->input('cource');
    return view('payment.payment', compact('reserve'));
} else {


        $qrCode = QrCode::size(150)->generate(route('owner-reserve', ['id' => $reserve->shop_id]));


    // QRコードを一時ファイルとして保存
$tempPath = tempnam(sys_get_temp_dir(), 'qr_');
file_put_contents($tempPath, $qrCode);

// 一時ファイルをS3にアップロード
$path = Storage::disk('s3')->putFile('qr_codes', new File($tempPath));

// データベースにQRコードのファイル名を保存
$reserve->qr = Storage::disk('s3')->url($path);
$reserve->save();

// 一時ファイルを削除
unlink($tempPath);
    // courceが選択されていない場合は直接done.blade.phpに遷移
    $reserve->save();
    return view('reserve.done', compact('reserve'));
}
}

    public function delete(Request $request)
{
    $reserve_id = $request->input('id');

    $reserve = Reserve::where('id', $reserve_id)->first();

    if ($reserve) {
        $reserve->delete();
    }

    return redirect()->route('mypage');
}


public function edit(Request $request)
{
    $reserve = $request->input('id');
    $reservation = Reserve::where('id', $reserve)->first();
    return view('reserve.reserve_edit', compact('reservation'));
}


public function update(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $this->validate($request, [
        'date' => 'required|date',
        'time' => 'required',
        'number_of_people' => 'required|integer',
    ]);

    $reservation = Reserve::find($request->input('id'));

    if ($request->input('number_of_people') != $reservation->number_of_people) {
        // number_of_people の変更がある場合は重複チェックをスキップ
        $reservation->number_of_people = $request->input('number_of_people');
        $reservation->save();
        return view('reserve.edit_done');
    } elseif ($request->input('date') != $reservation->date || $request->input('time') != $reservation->time) {
        // date または time の変更がある場合にのみ重複チェックを行う
        $is_reserved = Reserve::where([
            ['user_id', Auth::id()],
            ['date', $request->input('date')],
            ['time', $request->input('time')],
        ])->exists();

        if ($is_reserved) {
            return back()->withErrors(['time' => '同時刻に予約済みです。'])->withInput();
        }
    }

    $reservation->date = $request->input('date');
    $reservation->time = $request->input('time');
    $reservation->save();

    return view('reserve.edit_done');
}



public function pastReserves()
{
    $areas=Area::all();
    $genres=Genre::all();

        
         // ショップ情報を取得し、area_name と genre_name を関連付ける
        $pastReserves = Shop::select(
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

    $user = Auth::user();
    $pastReserves = Reserve::
    where('user_id', $user->id)
    ->where(function ($query) {
            $query->where('date', '<', Carbon::today())
                ->orWhere(function ($query) {
                    $query->where('date', '=', Carbon::today())
                        ->where('time', '<', Carbon::now()->format('H:i:s'));
                });
        })
    ->with('shop','shops_area','shops_genre','area','genre')
        ->get();

    return view('reserve.past', compact('areas','genres','pastReserves'));
}

}



