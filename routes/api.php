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
Route::get('getcategories', [CategoriesController::class, 'getcategories']);


Route::middleware('auth:api')->group(function () {
    Route::controller(CategoriesController::class)->group(function () {
        Route::post('categories', 'store')->name('categories.categories');
        // Route::get('getcategories', 'getcategories')->name('categories.getcategories');
    });

    Route::controller(ApiController::class)->group(function () {
        Route::get('locations', 'locations')->name('locations.locations');
        Route::post('userfollowers', 'userfollowers')->name('followers.userfollowers');
        Route::post('userlikes', 'userlikes')->name('followers.userlikes');
        Route::post('usershares', 'usershares')->name('followers.usershares');
        Route::get('getusersfollowers/{id?}', 'getusersfollowers')->name('followers.getusersfollowers');
        Route::get('followercheck/{user_id?}/{follower_id}', 'followercheck')->name('followers.followercheck');
        Route::get('getuserlikes/{like_id?}', 'getuserlikes')->name('followers.getuserlikes');
        Route::get('getusershares/{share_id?}', 'getusershares')->name('followers.getusershares');
    });

    Route::controller(SubscriptionsController::class)->group(function () {
        Route::post('subscriptions', 'store')->name('subscriptions.subscriptions');
        Route::get('getsubscriptions', 'getsubscriptions')->name('subscriptions.getsubscriptions');
        Route::post('usersubcriptions', 'usersubcriptions')->name('subscriptions.usersubcriptions');
        Route::get('getusersubcriptions/{id?}', 'getusersubcriptions')->name('subscriptions.getusersubcriptions');
    });

    Route::controller(BestPlaceController::class)->group(function () {
        Route::post('place', 'store')->name('place.place');
        Route::get('getplace', 'getplace')->name('place.getplace');
    });

    Route::controller(PostsController::class)->group(function () {
        Route::post('posts', 'store')->name('posts.place');
        Route::post('postlikes', 'postlikes')->name('posts.postlikes');
        Route::get('getpostlikes/{id?}', 'getpostlikes')->name('posts.getpostlikes');
        Route::post('postcomments', 'postcomments')->name('posts.postcomments');
        Route::get('getposts/{id?}', 'getposts')->name('posts.getposts');
        Route::get('getpostcommentlike/{id?}', 'getpostcommentlike')->name('posts.getpostcommentlike');
        Route::post('usercomments', 'usercomments')->name('place.usercomments');
        Route::get('getusercomments/{comment_id?}', 'getusercomments')->name('place.getusercomments');
    });
});
