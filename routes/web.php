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
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', 'HomeController@test');

Route::middleware(['role:Administrator','auth'])->group(function () {
    Route::get('/staffs', 'Administrator\PageController@staffs'); 
    Route::get('/agencies', 'Administrator\PageController@agencies'); 
    Route::get('/lgus', 'Administrator\PageController@lgus'); 
    Route::get('/lists', 'Administrator\PageController@settings'); 
});

Route::middleware(['role:Member','auth'])->group(function () {
    Route::get('/assetlists', 'Member\PageController@inventory'); 
    Route::get('/stations', 'Member\PageController@locations'); 
    Route::get('/assetlist/{id}', 'Member\PageController@viewasset'); 
});

Route::prefix('request')->group(function () {

    Route::post('/user/password', 'Administrator\UserController@password');
    Route::get('/regions', 'LocationController@regions');
    Route::get('/provinces/{id}', 'LocationController@provinces');
    Route::get('/municipalities/{id}', 'LocationController@municipalities');
    Route::get('/dropdown/{type}', 'DropdownController@lists');

    Route::prefix('admin')->group(function () {

        Route::get('/users/{keyword}', 'Administrator\UserController@index');
        Route::post('/user/store', 'Administrator\UserController@store');

        Route::get('/members/{keyword}', 'Administrator\MemberController@index');
        Route::get('/member/list', 'Administrator\MemberController@list');
        Route::post('/member/store', 'Administrator\MemberController@store');
        Route::get('/lgus/{keyword}', 'Administrator\MemberController@lgu');

        Route::get('/{type}/{keyword}', 'DropdownController@index');
        Route::post('/dropdown/{keyword}', 'DropdownController@store');

        Route::get('/packets', 'Administrator\PacketController@index');

    });

    Route::prefix('member')->group(function (){

        Route::post('/asset/store', 'Member\AssetController@store');
        Route::get('/assets/{keyword}', 'Member\AssetController@index');
        Route::get('/asset/{id}', 'Member\AssetController@view'); 
        Route::get('/asset/{id}/purchased', 'Member\AssetController@purchases'); 
        Route::get('/asset/{id}/locations', 'Member\AssetController@locations'); 
        Route::post('/status/update', 'Member\AssetController@status'); 

        Route::get('/locations', 'Member\LocationController@lists');
        Route::get('/location/lists/{keyword}', 'Member\LocationController@index');
        Route::post('/location/store', 'Member\LocationController@store');

        Route::get('/lists/{id}', 'Member\ListsController@index'); 
        Route::post('/tracker/store', 'Member\ListsController@store'); 
        Route::get('/coordinates/{id}', 'Member\ListsController@coordinates'); 
    });
});

Route::group(['middleware' => ['web', WelcomesNewUsers::class,]], function () {
    Route::get('welcome/{user}', [WelcomeController::class, 'showWelcomeForm'])->name('welcome');
    Route::post('welcome/{user}', [WelcomeController::class, 'savePassword']);
});
