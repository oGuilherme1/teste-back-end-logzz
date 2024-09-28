<?php

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadImage\UploadImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('produtos')->group(function () {
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::put('/{produtos}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{produtos}', [ProductController::class, 'show'])->name('products.show');
    Route::delete('/{produtos}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::middleware('auth')->prefix('categorias')->group(function () {
    Route::post('/', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/{categorias}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/select', [CategoryController::class, 'toSelected'])->name('category.select');
    Route::get('/{categorias}', [CategoryController::class, 'show'])->name('category.show');
    Route::delete('/{categorias}', [CategoryController::class, 'destroy'])->name('category.destroy');


});

require __DIR__.'/auth.php';
