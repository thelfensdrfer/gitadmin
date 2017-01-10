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

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::group(['prefix' => '/keys'], function() {
        Route::delete('/{user}/{key}/remove', 'KeyController@destroy')->name('key.destroy');
        Route::post('/{user}', 'KeyController@store')->name('key.store');
    });

    Route::group(['prefix' => '/benutzer'], function() {
        Route::get('/', 'UserController@index')->name('user.index');
        Route::get('/{user}/edit', 'UserController@edit')->name('user.edit');
    });

    Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');
});

Route::group(['middleware' => 'guest'], function() {
    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
    Route::post('login', 'Auth\LoginController@login')->name('auth.dologin');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});
