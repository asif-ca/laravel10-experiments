<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // abort(500); //Added for feature testing  
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('admin/dashboard', function () {
    // abort(500); //Added for feature testing  
    return view('dashboard');
})->middleware(['auth', 'verified','isAdmin'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('products', [ProductController::class, 'index'])->name('products.index');

Route::group(['middleware' => ['auth'], 'prefix' => 'product'], function () {
    
    Route::middleware(['isAdmin'])->group(function () {
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::POST('/create', [ProductController::class, 'store'])->name('product.store');
        Route::get('{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('{product}/update', [ProductController::class, 'update'])->name('product.update');
        Route::delete('{product}/delete', [ProductController::class, 'destroy'])->name('product.destroy');
    });
   
});