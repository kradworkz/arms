<?php

use Illuminate\Support\Facades\Route;
use Spatie\WelcomeNotification\WelcomesNewUsers;
use App\Http\Controllers\Auth\WelcomeController;

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
    Route::get('/assetlists', 'Member\PageController@inventory'); 
    Route::get('/locations', 'Member\PageController@list'); 
    Route::get('/assetlist/{id}', 'Member\PageController@viewasset'); 
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
        Route::get('/lists/s/{type}', 'Administrator\ListsController@lists');

    });

    Route::prefix('member')->group(function (){

        Route::get('/categories', 'Member\ListController@categories');
        Route::get('/vendors', 'Member\ListController@vendors');
        Route::get('/storage', 'Member\ListController@storages');


        Route::get('/type/{type}/{keyword}', 'Member\ListController@index');
        Route::post('/list/{keyword}', 'Member\ListController@store');
        Route::get('/storages', 'Member\ListController@storages');
        Route::get('/vendors', 'Member\ListController@vendors');
        Route::get('/lists/s/{type}', 'Member\ListController@lists');

        Route::post('/asset/store', 'Member\AssetController@store');
        Route::get('/assets/{keyword}', 'Member\AssetController@index');
        Route::get('/asset/{id}', 'Member\AssetController@view'); 
        Route::get('/asset/{id}/purchased', 'Member\AssetController@purchases'); 
        Route::get('/asset/{id}/locations', 'Member\AssetController@locations'); 

        Route::post('/location/store', 'Member\ListController@location');
        
        
    });
});

Route::group(['middleware' => ['web', WelcomesNewUsers::class,]], function () {
    Route::get('welcome/{user}', [WelcomeController::class, 'showWelcomeForm'])->name('welcome');
    Route::post('welcome/{user}', [WelcomeController::class, 'savePassword']);
});
