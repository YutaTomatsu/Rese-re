<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;

class MypageController extends Controller
{
    public function mypage()
    {
        $reservations = Reserve::where('user_id', auth()->id())->get();

        return view('mypage.mypage', compact('reservations'));

    
    }
}
