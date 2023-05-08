<?php

use App\Http\Controllers\DetailController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\OwnerShopController;
use App\Http\Controllers\OwnerReservationController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\CreateOwnerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Admin;
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


Gate::define('admin', function ($user) {
    return Admin::where('user_id', $user->id)->value('role') == 'admin';
});

Gate::define('owner', function ($user) {
    return Admin::where('user_id', $user->id)->value('role') == 'owner';
});

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

            $favorite_shops = array();
        if (Auth::check()) {
            $favorite_shops = Auth::user()->favorites()->pluck('shop_id')->toArray();
        }

        return view('welcome', compact('shops','areas','genres','favorite_shops'));
    })->name('dashboard');

    Route::get('/admin', function () {
        return view('admin.admin-dashboard');
    })->middleware(['can:admin'])->name('admin');

    Route::get('/owner', function () {

       $areas=Area::all();
    $genres=Genre::all();
    $shops = Shop::whereIn('shops.id', function ($query) {
        $query->select('shop_id')
              ->from('owners_reservations')
              ->where('user_id', Auth::user()->id);
    })
    ->select('shops.id as shop_id','shops.name', 'shops.about', 'shops.picture', 'areas.id as area_id', 'areas.area_name', 'genres.id as genre_id', 'genres.genre_name')
    ->leftJoin('shops_areas as sa', 'shops.id', '=', 'sa.shop_id')
    ->leftJoin('areas', 'sa.area_id', '=', 'areas.id')
    ->leftJoin('shops_genres as sg', 'shops.id', '=', 'sg.shop_id')
    ->leftJoin('genres', 'sg.genre_id', '=', 'genres.id')
    ->get();


    return view('owner.owner-dashboard', compact('shops','areas','genres'));
    })->middleware(['can:owner'])->name('owner');
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

Route::get('delete', [ReserveController::class, 'delete'])->name('delete');

Route::get('past', [ReserveController::class, 'pastReserves'])->name('reserves.past');

Route::get('edit', [ReserveController::class, 'edit'])->name('edit');

Route::put('update', [ReserveController::class, 'update'])->name('reservation.update');



Route::post('/favorites', 'FavoriteController@store')->name('favorites.store');
Route::delete('/favorites', 'FavoriteController@destroy')->name('favorites.destroy');



Route::post('/like', 'FavoriteController@like')->name('reviews.like');

Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');


Route::post('/favorite', [FavoriteController::class, 'favorite'])->name('favorite');

Route::get('/mypage', [MypageController::class, 'mypage'])->name('mypage');

Route::get('/reservations/{id}/qr', [QrCodeController::class, 'generate'])->name('reservations.qr');



Route::get('/createowner', [CreateOwnerController::class, 'store'])->name('users.store');

Route::get('/owner-create', [OwnerShopController::class, 'index'])->name('owner-create');

Route::post('/owner/shop/create', [OwnerShopController::class, 'store']);

Route::get('/owner-edit/{id}', [OwnerShopController::class, 'edit'])->name('owner-edit');

Route::put('/owner/shop/{id}', [OwnerShopController::class, 'update'])->name('owner.shop.update');

Route::get('/owner-reserve', [OwnerReservationController::class,'index'])->name('owner-reserve');

Route::get('/review', [ReviewController::class, 'create'])->name('review');

Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

Route::get('/mail/send', [MailController::class, 'send']);

Route::get('/mail', [MailController::class, 'mail'])->name('mail');

Route::get('/admins/create-email', [MailController::class, 'createEmail'])->name('admins.create-email');

Route::post('/admins/send-email', [MailController::class, 'sendEmail'])->name('admins.send-email');
