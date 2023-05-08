<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\Shop;

class Shops_area extends Model
{
    use HasFactory;

        protected $fillable = [
        'id',
        'shop_id',
        'area_id',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
