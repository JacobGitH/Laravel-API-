<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\FollowController;

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

Route::get('/posts', [PostsController::class, 'read']);
Route::get('/posts/read_single', [PostsController::class, 'readSingle']);
Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);

Route::get('/follow', [FollowController::class, 'showFollows']);
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/posts/create', [PostsController::class, 'create']);
    Route::put('/posts/update/{id}', [PostsController::class, 'update']);
    Route::delete('/posts/delete/{id}', [PostsController::class, 'delete']);

    Route::post('/user/logout', [UserController::class, 'logout']);
    Route::post('/follow/{id}', [FollowController::class, 'follow']);
    Route::delete('/follow/{id}', [FollowController::class, 'unfollow']);
});



//Route::middleware('auth:sanctum')->get('/products/create', [PostsController::class, 'create']);
