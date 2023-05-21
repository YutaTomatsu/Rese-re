<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserves_cource extends Model
{
    protected $fillable = ['reserve_id', 'cource'];

    public function reserve()
    {
        return $this->belongsTo(Reserve::class);
    }
}