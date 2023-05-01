<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Jobs\CreateVisitJob;

class Reserve extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'date',
        'time',
        'number_of_people',
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    protected static function booted()
    {
        static::created(function($reserve){
            DB::transaction (function () use ($reserve) {
                $reserveTime = Carbon::parse($reserve->date . ' ' . $reserve->time);
                $visitTime = $reserveTime->copy()->addMinutes(30)->diffInSeconds(Carbon::now());
                CreateVisitJob::dispatch($reserve) // ジョブをディスパッチ
            ->visitTime($visitTime); // 遅延時間を設定
                $visit = new Visit([
                    'user_id' => $reserve->user_id,
                    'shop_id' => $reserve->shop_id,
                    'reserve_id' => $reserve->id,
                ]);
                $visit->setCreatedAt($visitTime);
                $visit->setUpdatedAt($visitTime);
                $visit->save();
            },0);
        });
    }
}

