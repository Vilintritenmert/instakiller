<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('user/{user}', function (App\Models\User $user) {

    return response()->json([
        'data' => [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'count_of_posts' => $user->posts()->count(),
            'last_posted_title' => optional($user->posts->last())->title,
            'last_posted_image_url' => optional($user->posts->last())->path_url
            ]
        ]
    );
});

//Route::middleware('api:auth')->get('/user/{id}', function (Request $request) {
//
//
//});
