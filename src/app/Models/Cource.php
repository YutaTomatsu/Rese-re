<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cource extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'cource_1',
        'cource_2',
        'cource_3',
    ];

    // リレーションの定義
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
