<?php

use App\Http\Controllers\ProfileController;
use App\Models\Batch;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/notes', function () {
    return Inertia::render('Yes');
});
Route::get('/inventories', function () {
    return Inertia::render('Inventory');
});
Route::get('/batches', function () {
    return Inertia::render('Batch');
});

Route::get('/batches/latest', function () {
    return Inertia::render('Batch');
});

Route::get('/expenses', function () {
    return Inertia::render('Expenses');
});

Route::get('/batches/{batch}', function (Batch $batch) {
    return Inertia::render('BatchDetails', [
        'batch' => $batch
    ]);
});




require __DIR__ . '/auth.php';
