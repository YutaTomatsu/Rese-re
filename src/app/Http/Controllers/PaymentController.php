<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Stripe;
use App\Models\Reserve;
use App\Models\Reserves_cource;
use Exception;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * 決済フォーム表示
     */
    public function create()
    {
        return view('payment.payment');
    }




    public function store(Request $request)
{
    \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));

    $cource = $request->input('cource');

$amount = 0;

if ($cource === "1000円コース") {
    $amount = 1000;
} elseif ($cource === "10000円コース") {
    $amount = 10000;
} elseif ($cource === "100000円コース") {
    $amount = 100000;
} else {
    // エラーハンドリング：不正なコースが指定された場合の処理
}

try {
    \Stripe\Charge::create([
        'source' => $request->stripeToken,
        'amount' => $amount,
        'currency' => 'jpy',
    ]);
} catch (Exception $e) {
    return back()->with('flash_alert', '決済に失敗しました！('. $e->getMessage() . ')');
}

    // save the reserve
    $reserve = new Reserve();
    $reserve->user_id = Auth::id();
    $reserve->shop_id = $request->input('shop_id');
    $reserve->date = $request->input('date');
    $reserve->time = $request->input('time');
    $reserve->number_of_people = $request->input('number_of_people');
    $reserve->save();

    // save the reserve_cource
    $reserve_cource = new Reserves_cource();
    $reserve_cource->reserve_id = $reserve->id;
    $reserve_cource->cource = $request->input('cource');



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

    $reserve_cource->save();

    return view('payment.payment-done', compact('reserve'));
}

}
