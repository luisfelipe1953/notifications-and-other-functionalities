<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\AuthController;

Route::get('/send-mails', [MailController::class, 'sendMails'])->name('mail.sends')->middleware('auth');

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('welcome');
    Route::get('/markAsRead', 'markAsRead')->name('markAsRead');
    Route::post('/read-notification/{id}', 'readNotification')->name('readNotification');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'loginView')->name('login.view');
        Route::post('/login', 'login')->name('login');
        Route::get('/register', 'registerView')->name('register.view');
        Route::post('/register', 'register')->name('register');
    });
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('product.index');
    Route::get('/create/product', 'create')->name('product.create');
    Route::middleware('auth')->group(function () {
        Route::get('/products/trash', 'trash')->name('product.trash');
        Route::post('/create/product', 'store')->name('product.store');
    });
});

Route::controller(FileController::class)->group(function () {
    Route::get('/file-storage', 'index')->name('file.index');
    Route::post('/file-storage', 'uploadFile')->name('uploadFile')->middleware('auth');
    Route::get('/file-storage/download/{file}', 'downloadFile')->name('downloadFile');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/create/category', 'create')->name('category.create');
    Route::post('/create/category', 'store')->name('category.store');
});
