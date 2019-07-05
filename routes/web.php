<?php

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

use App\Models\Post;

Route::get('/', function () {
    return view('welcome', [
        'posts' => Post::paginate(3)
    ]);
});

Auth::routes();

Route::prefix('dashboard')->middleware('auth')->group(function(){
    Route::get('/', 'PostController@index')
        ->name('dashboard.index');

    Route::post('/add', 'PostController@add')
        ->name('dashboard.add');

    Route::get('/edit/{post}', 'PostController@editForm')
        ->middleware('can:update,post')
        ->name('dashboard.post-edit-form');

    Route::post('/edit/{post}', 'PostController@update')
        ->middleware('can:update,post')
        ->name('dashboard.update');

    Route::delete('{post}', 'PostController@destroy')
        ->middleware('can:delete,post')
        ->name('dashboard.delete');

    Route::get('profile', 'ProfileController@showProfile')
        ->name('dashboard.profile');

    Route::post('profile', 'ProfileController@update')
        ->name('dashboard.profile-update');

});




