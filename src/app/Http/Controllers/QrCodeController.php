<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{


    public function generate(Request $request)
    {
        $reservation = [
            'id' => $request->input('id'),
            'user_id' => $request->input('user_id'),
            'shop_id' => $request->input('shop_id'),
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'number_of_people' => $request->input('number_of_people'),
        ];
        // QRコードを生成する
    $qr_image = QrCode::size(400)->format('png')->generate($reservation);
    return $qr_image;
    }
}