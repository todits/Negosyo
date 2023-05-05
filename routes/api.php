<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\ExpensesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Models\Expenses;

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


Route::put('inventories/{inventory}', [InventoryController::class, 'update']);
Route::resource('inventories', InventoryController::class);

Route::get('batches/latest', [BatchController::class, 'latestBatch']);
Route::resource('batches', BatchController::class);


Route::resource('expenses', ExpensesController::class);
// Route::delete('expenses/{expenses}', [BatchController::class, 'destroy']);
