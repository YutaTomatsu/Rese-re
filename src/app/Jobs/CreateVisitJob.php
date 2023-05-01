<?php

namespace App\Jobs;

use App\Models\Visit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class CreateVisitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reserve;

    public function __construct($reserve)
    {
        $this->reserve = $reserve;
    }

    public function handle()
    {
        $reserveTime = Carbon::parse($this->reserve->date . ' ' . $this->reserve->time);
        $visitTime = $reserveTime->copy()->addMinutes(30);
        $visit = new Visit([
            'user_id' => $this->reserve->user_id,
            'shop_id' => $this->reserve->shop_id,
            'reserve_id' => $this->reserve->id,
        ]);
        $visit->setCreatedAt($visitTime);
        $visit->setUpdatedAt($visitTime);
        $visit->save();
    }
}