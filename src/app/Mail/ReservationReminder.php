<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function build()
    {
        return $this->view('emails.reservation_reminder')
                    ->subject('ご予約当日のお知らせ');
    }
}
