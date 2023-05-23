<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shops_area;
use App\Models\Shops_genre;
use App\Models\Reserve;
use App\Models\Favorite;
use App\Models\Review;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'about',
        'picture',
        'id',

    ];

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'shops_areas');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'shops_genres');
    }

    public function reserve()
    {
        return $this->belongsTo(Reserve::class, 'reserves');
    }

    /**
     * ユーザーがお気に入り登録しているかどうかを判定する
     *
     * @param User $user
     * @return bool
     */
    public function isFavoritedBy(User $user)
    {
        return $this->favorites()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * この店舗に対するお気に入り登録を取得する
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function likes()
    {
        return $this->hasMany('App\Favorite');
    }
    //後でViewで使う、いいねされているかを判定するメソッド。
    public function isLikedBy($user): bool
    {
        return Favorite::where('user_id', $user->id)->where('shop_id', $this->id)->first() !== null;
    }

    public function shops_areas()
    {
        return $this->belongsToMany(Area::class, 'shops_areas');
    }

    public function shops_genres()
    {
        return $this->belongsToMany(Genre::class, 'shops_genres');
    }

    public function reviews()
    {
        return $this->hasmany(Review::class);
    }
}
