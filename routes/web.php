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

    Route::group(['prefix' => 'item', 'as' => 'item.'], function () {
        Route::get('/list', [App\Http\Controllers\ItemController::class, 'index'])->name('list');
        Route::get('/{item}', [App\Http\Controllers\ItemController::class, 'item'])->name('item');
        Route::post('/add-new', [App\Http\Controllers\ItemController::class, 'add'])->name('add');
        Route::delete('/delete/{item}', [App\Http\Controllers\ItemController::class, 'delete'])->name('delete');
        Route::put('/update/{item}', [App\Http\Controllers\ItemController::class, 'update'])->name('update');

        // Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('list');
        // Route::get('/{id}', [App\Http\Controllers\ItemController::class, 'getItem'])->name('item');
        // Route::post('/', [App\Http\Controllers\ItemController::class, 'add'])->name('add');
        // Route::delete('/{id}', [App\Http\Controllers\ItemController::class, 'delete'])->name('delete');
        // Route::put('/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('update');
    });


    //Categories
    Route::resource('/categories','App\Http\Controllers\CategoryController');
    //Stock
    Route::resource('/stock','App\Http\Controllers\StockController');

});
