<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\BestPlaceController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SubscriptionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);
Route::post('userupdate', [ApiController::class, 'userupdate']);
Route::post('phoneotp', [ApiController::class, 'phoneotp']);

Route::middleware('auth:api')->group(function () {
    Route::controller(CategoriesController::class)->group(function () {
        Route::post('categories', 'store')->name('categories.categories');
        Route::get('getcategories', 'getcategories')->name('categories.getcategories');
    });

    Route::controller(ApiController::class)->group(function () {
        Route::get('locations', 'locations')->name('locations.locations');
    });

    Route::controller(SubscriptionsController::class)->group(function () {
        Route::post('subscriptions', 'store')->name('subscriptions.subscriptions');
        Route::get('getsubscriptions', 'getsubscriptions')->name('subscriptions.getsubscriptions');
    });

    Route::controller(BestPlaceController::class)->group(function () {
        Route::post('place', 'store')->name('place.place');
        Route::get('getplace', 'getplace')->name('place.getplace');
    });

    Route::controller(PostsController::class)->group(function () {
        Route::post('posts', 'store')->name('posts.place');
        Route::get('getposts', 'getposts')->name('posts.getposts');
    });
});
