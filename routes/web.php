<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SettingController;

// Route Guest Controller
Route::get('/', [GuestController::class, 'index'])->name('guest.index');

// Route Product Controller
Route::get('/products/index', [ProductController::class, 'index'])->name('product.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/products/store', [ProductController::class, 'store'])->name('product.store');
Route::get('/products/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/products/update/{product}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/products/delete/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

// Route Categories Controller
Route::get('/categories/index', [CategoryController::class, 'index'])->name('category.index');
Route::post('/categories/store', [CategoryController::class, 'store'])->name('category.store');
Route::put('/categories/update/{category}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/categories/delete/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

// Route Status Controller
Route::get('/statuses/index', [StatusController::class, 'index'])->name('status.index');
Route::post('/statuses/store', [StatusController::class, 'store'])->name('status.store');
Route::put('/statuses/update/{status}', [StatusController::class, 'update'])->name('status.update');
Route::delete('/statuses/delete/{status}', [StatusController::class, 'destroy'])->name('status.destroy');

// Route Setting Controller
Route::get('/settings/index', [SettingController::class, 'index'])->name('setting.index');
Route::post('/settings/store', [SettingController::class, 'store'])->name('setting.store');
Route::get('/settings/dowload/{setting}', [SettingController::class, 'download'])->name('setting.download');

