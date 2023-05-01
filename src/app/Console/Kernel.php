<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
{
    // 予約情報のリマインダーを送信するタスクを定義
    $schedule->call(function () {
        // 予約当日の日付を取得
        $today = Carbon::today();

        // 予約当日の朝9時に予約情報のリマインダーを送信する
        $reservations = Reserve::where('date', $today)->get();
        foreach ($reservations as $reservation) {
            $user = User::find($reservation->user_id);
            $shop = Shop::find($reservation->shop_id);
            $message = "予約日時：{$reservation->date} {$reservation->time}\n";
            $message .= "店名：{$shop->name}\n";
            $message .= "予約人数：{$reservation->number_of_people}\n";
            Mail::to($user->email)->send(new ReservationReminder($message));
        }
    })->dailyAt('09:00');
}

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
