<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_name',
        'id',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
