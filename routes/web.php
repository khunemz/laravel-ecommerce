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

Route::get('/', [HomeController::class, 'index']);
Route::get('/getProducts/{page}/{limit}/{category}', [ProductController::class, 'getProducts']);
Route::get('/getCategory', [ProductController::class, 'getCategory']);
Route::get('/products/view/{id}', [ProductController::class, 'view']);
Route::post('/sale/addCart', [SaleController::class, 'addCart']);
Route::get('/sale/getBasket/{id}', [SaleController::class, 'getBasket']);
Route::get('/sale/viewbasket', [SaleController::class, 'viewbasket']);
Route::get('/sale/delete/{id}', [SaleController::class, 'delete']);
Route::get('/sale/checkout', [SaleController::class, 'checkout']);
Route::get('/sale/get_provinces', [SaleController::class, 'getProvinces']);
Route::get('/sale/get_districts/{id}', [SaleController::class, 'getDistricts']);
Route::get('/sale/get_sub_districts/{id}', [SaleController::class, 'getSubDistricts']);
Route::post('/sale/add_address', [SaleController::class, 'addAddress']);
Route::get('/sale/presubmit', [SaleController::class, 'presubmit']);






