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
    });

    Route::controller(ApiController::class)->group(function () {
        Route::post('changepassword', 'changepassword')->name('user.changepassword');
        Route::post('updateregister', 'updateregister')->name('user.updateregister');
        Route::post('registerdelete/{id}', 'registerdelete')->name('user.registerdelete');
        Route::get('locations', 'locations')->name('locations.locations');
        Route::post('userfollowers', 'userfollowers')->name('followers.userfollowers');
        Route::post('usershares', 'usershares')->name('followers.usershares');
        Route::get('getusershares/{id?}', 'getusershares')->name('followers.getusershares');
        Route::get('getusersfollowers/{id?}', 'getusersfollowers')->name('followers.getusersfollowers');
        Route::get('followercheck/{user_id?}/{follower_id?}', 'followercheck')->name('followers.followercheck');
        Route::post('followUnfollow', 'followUnfollow')->name('followers.followUnfollow');
        Route::get('followersremove/{follower_id?}', 'followersremove')->name('followers.followersremove');
        Route::get('myfollowers', 'myfollowers')->name('followers.myfollowers');
        Route::post('unfollow', 'unfollow')->name('followers.unfollow');
        Route::post('report', 'report')->name('followers.report');
        Route::post('followaccept', 'followaccept')->name('followers.followaccept');
        Route::get('getacceptfollower/{user_id?}', 'getacceptfollower')->name('followers.getacceptfollower');
        Route::post('following', 'following')->name('followers.following');
        Route::get('getmyfollowing/{user_id?}', 'getmyfollowing')->name('followers.getmyfollowing');
        Route::post('followersrequest', 'followersrequest')->name('followers.followersrequest');
        Route::get('getfollowersrequest', 'getfollowersrequest')->name('followers.getfollowersrequest');
        Route::get('allpostlikes/{post_id}', 'allpostlikes')->name('followers.allpostlikes');
    });

    Route::controller(SubscriptionsController::class)->group(function () {
        Route::post('subscriptions', 'store')->name('subscriptions.subscriptions');
        Route::get('getsubscriptions', 'getsubscriptions')->name('subscriptions.getsubscriptions');
        Route::get('getpostsubscriptions/{subscriptions_id?}', 'getpostsubscriptions')->name('subscriptions.getpostsubscriptions');
        Route::post('usersubcriptions', 'usersubcriptions')->name('subscriptions.usersubcriptions');
        Route::get('getusersubcriptions/{id?}', 'getusersubcriptions')->name('subscriptions.getusersubcriptions');
        Route::get('winners', 'winners')->name('subscriptions.winners');
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
        Route::post('userpostcomments', 'userpostcomments')->name('posts.userpostcomments');
        Route::get('getuserpostcomments/{post_id?}', 'getuserpostcomments')->name('posts.getuserpostcomments');
        Route::post('userreplycomments', 'userreplycomments')->name('posts.userreplycomments');
        Route::get('getuserreplycomments/{comment_id?}', 'getuserreplycomments')->name('posts.getuserreplycomments');
        Route::get('getuserpost/{comment_id?}', 'getuserpost')->name('posts.getuserpost');
    });
});
