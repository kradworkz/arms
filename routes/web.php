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

Route::get('/assets/{id}/{keyword}', 'PublicController@index');
Route::get('/stations/lists', 'Users\Member\StationController@stations');
Route::get('/assets/lists/{id}/{keyword}', 'PublicController@assets');

Route::post('/api/login', 'Api\DeviceController@login');
Route::post('/api/check', 'Api\DeviceController@check');
Route::post('/api/devices', 'Api\DeviceController@devices');
Route::post('/api/device/search', 'Api\DeviceController@search');


//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////

Route::middleware(['auth'])->group(function () {
    Route::get('/trackers', 'PageController@devices'); 
});

Route::middleware(['role:Administrator','auth'])->group(function () {
    Route::get('/staffs', 'PageController@staffs'); 
    Route::get('/agencies', 'PageController@agencies'); 
    Route::get('/lgus', 'PageController@lgus'); 
    Route::get('/lists', 'PageController@settings'); 
    Route::get('/devices', 'PageController@deviceslist'); 
});

Route::middleware(['role:Member','auth'])->group(function () {
    Route::get('/assetlists', 'PageController@inventory'); 
    Route::get('/stations', 'PageController@locations'); 
    Route::get('/requests', 'PageController@requests'); 
    Route::get('/assetlist/{id}', 'PageController@viewasset'); 
    Route::get('/search', 'PageController@search'); 
});


//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////


Route::prefix('request')->group(function () {
    /////Location
    Route::get('/agency', 'HomeController@agency');
    Route::post('/user/password', 'Users\Admin\UserController@password');
    Route::get('/regions', 'HomeController@regions');
    Route::get('/provinces/{id}', 'HomeController@provinces');
    Route::get('/municipalities/{id}', 'HomeController@municipalities');
    /////Dropdown
    Route::get('/dropdown/{classification}/{type}/{keyword}', 'DropdownController@index');
    Route::get('/dropdowns/{classification}/{type}', 'DropdownController@lists');
    Route::get('/dropdowncount/{classification}/{type}', 'DropdownController@count');
    Route::post('/dropdown/store', 'DropdownController@store');

    // Route::post('/agency/search', 'Administrator\MemberController@search');
    Route::prefix('admin')->group(function () {
        /////Users
        Route::get('/users/{keyword}', 'Users\Admin\UserController@index');
        Route::post('/user/store', 'Users\Admin\UserController@store');
        /////Members
        Route::get('/members/{keyword}', 'Users\Admin\MemberController@index');
        Route::get('/member/list', 'Users\Admin\MemberController@lists');
        Route::post('/member/store', 'Users\Admin\MemberController@store');
        Route::get('/member/lgu/{keyword}', 'Users\Admin\MemberController@lgu');
        // Route::get('/packets', 'Administrator\PacketController@index');

        Route::post('/device/store', 'Users\Admin\DeviceController@store');
        Route::get('/devices/{keyword}', 'Users\Admin\DeviceController@index');
    });

    Route::prefix('member')->group(function (){

        Route::get('/totals', 'Users\Member\HomeController@total');

        Route::get('/locations', 'Users\Member\StationController@lists');
        Route::get('/location/lists/{keyword}', 'Users\Member\StationController@index');
        Route::post('/location/store', 'Users\Member\StationController@store');

        Route::post('/asset/store', 'Users\Member\AssetController@store');
        Route::get('/assets/{keyword}', 'Users\Member\AssetController@index');
        Route::get('/asset/{id}', 'Users\Member\AssetController@view'); 
        Route::get('/asset/{id}/purchased', 'Users\Member\AssetController@purchases'); 
        Route::post('/asset/locations', 'Users\Member\AssetController@locations'); 
        Route::post('/status/update', 'Users\Member\AssetController@status'); 
        Route::post('/quantity/update', 'Users\Member\AssetController@updateQuantity'); 

        Route::get('/lists/{id}/{keyword}', 'Users\Member\ListsController@index'); 
        Route::post('/tracker/store', 'Users\Member\ListsController@store'); 
        Route::post('/asset/update', 'Users\Member\ListsController@update'); 
        Route::get('/coordinates/{id}', 'Users\Member\ListsController@coordinates'); 
        Route::get('/assets/search/{keyword}', 'Users\Member\ListsController@search');
        Route::get('/assets/search2/{location}/{category}/{status}/{keyword}', 'Users\Member\ListsController@search2');
        Route::post('/status/up', 'Users\Member\ListsController@status'); 
        Route::get('/foraction/{type}', 'Users\Member\ListsController@check'); 
        Route::get('/logs/{id}', 'Users\Member\ListsController@logs'); 
        
    });
});

Route::group(['middleware' => ['web', WelcomesNewUsers::class,]], function () {
    Route::get('welcome/{user}', [WelcomeController::class, 'showWelcomeForm'])->name('welcome');
    Route::post('welcome/{user}', [WelcomeController::class, 'savePassword']);
});
