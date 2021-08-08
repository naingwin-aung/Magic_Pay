<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\WalletController;
use App\Http\Controllers\Backend\AdminUserController;

//Admin User PageController
Route::prefix('/admin')->name('admin.')->middleware(['auth:admin'])->group(function() {
    Route::get('/', [PageController::class, 'home'])->name('dashboard');
    Route::resource('admin', AdminUserController::class)->except('show');
    Route::resource('user', UserController::class)->except('show');
    Route::get('wallet', [WalletController::class, 'home'])->name('wallet');

    Route::get('admin-user/datatable/ssd', [AdminUserController::class, 'serverSideData']);
    Route::get('user/datatable/ssd', [UserController::class, 'serverSideData']);
    Route::get('/wallet/datatable/ssd', [WalletController::class, 'serverSideData']);
});