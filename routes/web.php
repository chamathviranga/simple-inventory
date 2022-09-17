<?php

use Illuminate\Support\Facades\Auth;
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
    return redirect('/login');
});

Auth::routes();


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Route::group(['prefix' => 'item', 'as' => 'item.'], function () {
    //     Route::get('/list', [App\Http\Controllers\ItemController::class, 'index'])->name('list');
    // });

    //Items
    Route::resource('/items','App\Http\Controllers\ItemController');
    Route::get('/item-categories',[App\Http\Controllers\ItemController::class,'getCategories'])->name('item-categories');

    //Categories
    Route::resource('/categories','App\Http\Controllers\CategoryController');
    
    //Stock
    Route::resource('/stock','App\Http\Controllers\StockController');

    Route::post('/stock/searchItems',[App\Http\Controllers\StockController::class,'searchItem'])->name('stock-enter-search-item');

});

?>