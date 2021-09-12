<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SaleController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/getProducts/{page}/{limit}/{category}', [ProductController::class, 'getProducts']);
Route::get('/getCategory', [ProductController::class, 'getCategory']);
Route::get('/products/view/{id}', [ProductController::class, 'view']);




Route::prefix('sale')->group(function () {
    Route::post('/addCart', [SaleController::class, 'addCart'])->middleware(['auth']);
    Route::get('/getBasket/{id}', [SaleController::class, 'getBasket']);
    Route::get('/viewbasket', [SaleController::class, 'viewbasket'])->middleware(['auth']);
    Route::get('/delete/{id}', [SaleController::class, 'delete'])->middleware(['auth']);
    Route::get('/checkout', [SaleController::class, 'checkout'])->middleware(['auth']);
    Route::get('/get_provinces', [SaleController::class, 'getProvinces'])->middleware(['auth']);
    Route::get('/get_districts/{id}', [SaleController::class, 'getDistricts'])->middleware(['auth']);
    Route::get('/get_sub_districts/{id}', [SaleController::class, 'getSubDistricts'])->middleware(['auth']);
    Route::post('/add_address', [SaleController::class, 'addAddress'])->middleware(['auth']);
    Route::get('/presubmit/{id}', [SaleController::class, 'presubmit'])->middleware(['auth'])->name('sale.presubmit');
    Route::post('/processorder', [SaleController::class, 'processorder'])->middleware(['auth']);
    Route::post('/update_cart', [SaleController::class, 'updateCart'])->middleware(['auth']);
    Route::get('/getorder/{id}', [SaleController::class, 'getorder'])->middleware(['auth']);
    Route::get('/makepayment/{id}', [SaleController::class, 'makepayment'])->middleware(['auth']);
});

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';