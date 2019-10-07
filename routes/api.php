<?php

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

// Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
//     Route::post('login', 'AuthController@login')->name('api.login');
//     Route::post('signup', 'AuthController@signup');

//     Route::group(['middleware' => 'auth:api'], function () {
//         Route::get('logout', 'AuthController@logout');
//         Route::get('user', 'AuthController@user');
//     });
// });

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');
Route::post('logout', 'UserController@logout');
Route::get('open', 'DataController@open');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('closed', 'DataController@closed');
});

Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password',
], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});

// Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
//     Route::post('/auth/token', 'Auth\LoginController@auth');
//     Route::post('login', 'AuthController@login')->name('api.login');
//     Route::post('register', 'AuthController@register')->name('api.register');
// });

// Route::group(['middleware' => ['api', 'auth'], 'prefix' => 'recipe'], function () {
// // Route::group(['middleware' => ['api'], 'prefix' => 'recipe'], function () {
//     Route::get('all', 'RecipeController@all')->name('recipe.all');
//     Route::get('show/{id}', 'RecipeController@show')->name('recipe.show');
//     Route::post('create', 'RecipeController@create')->name('recipe.create');
//     Route::post('update/{id}', 'RecipeController@update')->name('recipe.update');
//     Route::post('delete/{id}', 'RecipeController@delete')->name('recipe.delete');
// });
