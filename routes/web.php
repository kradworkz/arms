<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['role:Administrator','auth'])->group(function () {
    Route::get('/staffs', 'Administrator\PageController@staffs'); 
    Route::get('/agencies', 'Administrator\PageController@agencies'); 
    Route::get('/lgus', 'Administrator\PageController@lgus'); 
    Route::get('/lists', 'Administrator\PageController@settings'); 
});

Route::middleware(['role:Member','auth'])->group(function () {
    Route::get('/inventory', 'Member\PageController@inventory'); 
});

Route::prefix('request')->group(function () {

    Route::post('/user/password', 'Administrator\UserController@password');
    Route::get('/regions', 'LocationController@regions');
    Route::get('/provinces/{id}', 'LocationController@provinces');
    Route::get('/municipalities/{id}', 'LocationController@municipalities');

    Route::prefix('admin')->group(function () {

        Route::get('/users/{keyword}', 'Administrator\UserController@index');
        Route::post('/user/store', 'Administrator\UserController@store');

        Route::get('/members/{keyword}', 'Administrator\MemberController@index');
        Route::get('/member/list', 'Administrator\MemberController@list');
        Route::post('/member/store', 'Administrator\MemberController@store');
        Route::get('/lgus/{keyword}', 'Administrator\MemberController@lgu');

        Route::get('/{type}/{keyword}', 'Administrator\ListsController@index');
        Route::post('/list/{keyword}', 'Administrator\ListsController@store');

    });
});
