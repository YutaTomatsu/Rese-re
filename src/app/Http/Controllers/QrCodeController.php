<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Reserve;

class QrCodeController extends Controller
{


    public function index($id)
    {
        $reserve = Reserve::where('id', $id)->firstOrFail();
    return view('mypage.qr', compact('reserve'));
    }
}