<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'genre_name',
        'id',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class, 'shops_genres');
    }
}
