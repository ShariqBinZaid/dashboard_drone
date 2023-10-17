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
        Route::post('usershares', 'usershares')->name('followers.usershares');
        Route::get('getusershares/{id?}', 'getusershares')->name('followers.getusershares');
        Route::get('getusersfollowers/{id?}', 'getusersfollowers')->name('followers.getusersfollowers');
        Route::get('followercheck/{user_id?}/{post_id?}', 'followercheck')->name('followers.followercheck');
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
        Route::get('getposts', 'getposts')->name('posts.getposts');
        Route::get('viewposts/{id?}', 'viewposts')->name('posts.viewposts');
        Route::post('userlike', 'userlike')->name('posts.userlike');
        Route::get('likecheck/{user_id?}/{post_id?}', 'likecheck')->name('posts.likecheck');
        Route::post('userpostlikes', 'userpostlikes')->name('posts.userpostlikes');
        Route::get('getuserpostlikes/{post_id?}', 'getuserpostlikes')->name('posts.getuserpostlikes');
        Route::post('userpostcomments', 'userpostcomments')->name('place.userpostcomments');
        Route::get('getuserpostcomments/{post_id?}', 'getuserpostcomments')->name('posts.getuserpostcomments');
        Route::post('userreplycomments', 'userreplycomments')->name('place.userreplycomments');
        Route::get('getuserreplycomments/{comment_id?}', 'getuserreplycomments')->name('place.getuserreplycomments');
    });
});
