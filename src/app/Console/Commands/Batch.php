<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Reserve;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationReminder;

class Batch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendmail';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'タスクスケジューラによるメール送信機能';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
{
    // 予約情報のリマインダーを送信するタスクを定義
    $reservations = Reserve::with(['reserveUser', 'reserveShop'])
        ->where('date', Carbon::today())
        ->get();

    foreach ($reservations as $reservation) {
        $user = $reservation->reserveUser;
        $shop = $reservation->reserveShop;

        $text = "予約日時：{$reservation->date} {$reservation->time}\n";
        $text .= "店名：{$shop->name}\n";
        $text .= "予約人数：{$reservation->number_of_people}\n";

        Mail::to($user->email)->send(new ReservationReminder($text));
    }
}
}
