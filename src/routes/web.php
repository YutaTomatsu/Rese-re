<?php

use App\Http\Controllers\DetailController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\Auth\OwnerLoginController;
use App\Http\Controllers\Auth\OwnerRegisterController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MypageController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ShopController::class, 'index'])->name('Home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        $areas=Area::all();
        $genres=Genre::all();

        
         // ショップ情報を取得し、area_name と genre_name を関連付ける

        $shops = Shop::select(
                'shops.id as shop_id',
                'shops.name',
                'shops.picture',
                'areas.area_name',
                'genres.genre_name'
            )
            ->leftJoin('shops_areas', 'shops.id', '=', 'shops_areas.shop_id')
            ->leftJoin('areas', 'shops_areas.area_id', '=', 'areas.id')
            ->leftJoin('shops_genres', 'shops.id', '=', 'shops_genres.shop_id')
            ->leftJoin('genres', 'shops_genres.genre_id', '=', 'genres.id')
            ->get();

        return view('welcome', compact('shops','areas','genres'));
    })->name('dashboard');
});



Route::prefix('admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('login', [AdminLoginController::class, 'store'])->name('login.store');
 
    Route::get('register', [AdminRegisterController::class, 'create'])->name('admin.register');
    Route::post('register', [AdminRegisterController::class, 'store'])->name('admin.store');
 
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index']);
    });
});


Route::prefix('owner')->group(function () {
    Route::get('login', [OwnerLoginController::class, 'create'])->name('owner.login');
    Route::post('login', [OwnerLoginController::class, 'store']);
 
    Route::get('register', [OwnerRegisterController::class, 'create'])->name('owner.register');
    Route::post('register', [OwnerRegisterController::class, 'store']);
 
    Route::middleware('auth:owner')->group(function () {
        Route::get('dashboard', [OwnerDashboardController::class, 'index']);
    });
});



Route::get('detail', [DetailController::class, 'index'])->name('detail');

Route::get('search', [SearchController::class, 'search'])->name('search');

Route::post('reserve', [ReserveController::class, 'reserve']);



Route::post('/favorites', 'FavoriteController@store')->name('favorites.store');
Route::delete('/favorites', 'FavoriteController@destroy')->name('favorites.destroy');



Route::post('/like', 'FavoriteController@like')->name('reviews.like');

Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');


Route::post('/favorite', [FavoriteController::class, 'favorite'])->name('favorite');

Route::get('/mypage', [MypageController::class, 'mypage'])->name('mypage');


