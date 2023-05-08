<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\User;
use App\Mail\CustomMail;

class MailController extends Controller
{
    public function mail(Request $request)
    {
        return view('emails.create-email');
    }

    public function createEmail()
{
    return view('admins.create-email');
}

public function sendEmail(Request $request)
{
    $subject = $request->input('subject');
    $message = $request->input('message');

    $users = User::whereNotIn('id', function ($query) {
        $query->select('user_id')->from('admins');
    })->get();

    foreach ($users as $user) {
        Mail::to($user->email)->send(new CustomMail($subject, $message));
    }

    return redirect()->back()->with('status', 'Email sent successfully');
}







    public function send(Request $request)
    {
        $name = 'テスト ユーザー';
        $email = 'test@example.com';

        Mail::send(new TestMail($name, $email));

        return view('welcome');
    }


}
