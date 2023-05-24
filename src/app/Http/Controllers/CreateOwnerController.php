<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Admin;

class CreateOwnerController extends Controller
{


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^[a-zA-Z0-9]+$/'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        Admin::create([
            'user_id' => $user->id,
            'role' => 'owner',
        ]);

        Session::flash('success', '店舗代表者が作成されました。');

        return redirect()->back();
    }
}
