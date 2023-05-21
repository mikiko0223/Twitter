<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/timeline', [App\Http\Controllers\TweetController::class, 'showTimelinePage'])->name('timeline');

Route::post('/timeline', [App\Http\Controllers\TweetController::class, 'postTweet']);

Route::post('/timeline/delete/{id}', [App\Http\Controllers\TweetController::class, 'destroy'])->name('destroy');

Route::get('/user/show/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('show');

//いいねを作成
Route::get('/tweets/{tweet_id}/likes', [App\Http\Controllers\LikeController::class, 'store'])->name('store');

//いいねを削除
Route::get('/likes/{like_id}/', [App\Http\Controllers\LikeController::class, 'destroy'])->name('destroy');