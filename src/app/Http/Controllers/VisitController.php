<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function visit()
    {
        return view('mypage.visit');
    }
}
