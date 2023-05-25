<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\Genre;

class ShopsGenre extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'shop_id',
        'genre_id',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
