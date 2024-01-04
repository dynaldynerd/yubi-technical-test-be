<?php

use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\StyleController;
use App\Http\Controllers\ColorMethodController;
use App\Http\Controllers\ColorNameMethodController;
use App\Http\Controllers\ColorNameSalesStyleController;
use App\Http\Controllers\ColorMethodSalesStyleController;
use App\Http\Controllers\SalesStyleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::prefix('sales_orders')->group(function () {
    Route::get('/', [SalesOrderController::class, 'index']);
    Route::get('/detail/{id}', [SalesOrderController::class, 'getSalesOrderById']);
    Route::post('/', [SalesOrderController::class, 'store']);
    Route::post('/new', [SalesOrderController::class, 'createSales']);
    Route::put('/{id}', [SalesOrderController::class, 'update']);
    Route::put('/new/{id}', [SalesOrderController::class, 'updateSales']);
    Route::delete('/{id}', [SalesOrderController::class, 'destroy']);
    Route::delete('/new/{id}', [SalesOrderController::class, 'deleteSales']);
    Route::get('/{id}', [SalesOrderController::class, 'show']);
});

Route::prefix('color_method')->group(function () {
    Route::get('/', [ColorMethodController::class, 'index']);
    Route::post('/', [ColorMethodController::class, 'store']);
    Route::put('/{id}', [ColorMethodController::class, 'update']);
    Route::delete('/{id}', [ColorMethodController::class, 'destroy']);
    Route::get('/{id}', [ColorMethodController::class, 'show']);
});


Route::prefix('color_name_method')->group(function () {
    Route::get('/', [ColorNameMethodController::class, 'index']);
    Route::get('/color_method/{id}', [ColorNameMethodController::class, 'showByColorMethodId']);
    Route::post('/', [ColorNameMethodController::class, 'store']);
    Route::put('/{id}', [ColorNameMethodController::class, 'update']);
    Route::delete('/{id}', [ColorNameMethodController::class, 'destroy']);
    Route::get('/{id}', [ColorNameMethodController::class, 'show']);
});

Route::prefix('color_method_sales_style')->group(function () {
    Route::get('/', [ColorMethodSalesStyleController::class, 'index']);
    Route::post('/', [ColorMethodSalesStyleController::class, 'store']);
    Route::put('/{id}', [ColorMethodSalesStyleController::class, 'update']);
    Route::delete('/{id}', [ColorMethodSalesStyleController::class, 'destroy']);
    Route::get('/{id}', [ColorMethodSalesStyleController::class, 'show']);
});
Route::prefix('color_name_sales_styles')->group(function () {
    Route::get('/', [ColorNameSalesStyleController::class, 'index']);
    Route::post('/', [ColorNameSalesStyleController::class, 'store']);
    Route::put('/{id}', [ColorNameSalesStyleController::class, 'update']);
    Route::delete('/{id}', [ColorNameSalesStyleController::class, 'destroy']);
    Route::get('/{id}', [ColorNameSalesStyleController::class, 'show']);
});


Route::prefix('styles')->group(function () {
    Route::get('/', [StyleController::class, 'index']);
    Route::post('/', [StyleController::class, 'store']);
    Route::put('/{id}', [StyleController::class, 'update']);
    Route::delete('/{id}', [StyleController::class, 'destroy']);
    Route::get('/{id}', [StyleController::class, 'show']);
});

Route::prefix('sales_styles')->group(function () {
    Route::get('/', [SalesStyleController::class, 'index']);
    Route::get('/tbl', [SalesStyleController::class, 'joinSOandStyle']);
    Route::post('/', [SalesStyleController::class, 'store']);
    Route::put('/{id}', [SalesStyleController::class, 'update']);
    Route::delete('/{id}', [SalesStyleController::class, 'destroy']);
    Route::get('/{id}', [SalesStyleController::class, 'show']);
});
