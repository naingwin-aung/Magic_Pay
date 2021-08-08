<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Frontend\NotificationController;

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

//User Auth
Auth::routes();

//Admin Auth
Route::get('/admin/login', [AdminLoginController::class, 'showAdminLoginForm']);
Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login');
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

//User Home
Route::middleware(['auth'])->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::get('/update-password', [PageController::class, 'updatePasswordForm'])->name('update-passwordform');
    Route::post('/update-password', [PageController::class, 'updatePassword'])->name('update-password');
    Route::get('/wallet', [PageController::class, 'wallet'])->name('wallet');
    Route::get('/to-verify-account', [PageController::class, 'toVerifyAccount']);
    Route::get('/receive-qr', [PageController::class, 'receiveQr'])->name('receive-qr');
    Route::get('/transfer', [PageController::class, 'transferForm'])->name('transfer');
    Route::get('/transfer-confirmform', [PageController::class, 'transferConfirmForm'])->name('transfer.confirmform');
    Route::post('/transfer-complete', [PageController::class, 'transferComplete'])->name('transfer_complete');
    Route::get('/password-check', [PageController::class, 'passwordCheck'])->name('password-check');
    Route::get('/transaction', [PageController::class, 'transaction'])->name('transaction');
    Route::get('/transaction/detail/{trx_id}', [PageController::class, 'transactionDetail'])->name('transaction.detail');
    Route::get('/transfer-hash', [PageController::class, 'transferHash']);

    Route::get('/scan-and-pay', [PageController::class, 'scanAndPay'])->name('scanAndPay');
    Route::get('/scan-and-pay-form', [PageController::class, 'scanAndPayForm'])->name('scanAndPay.form');
    Route::get('/scan-and-pay-confirm', [PageController::class, 'scanAndPayConfirm'])->name('scanAndPayConfirm');
    Route::post('/scan-and-pay-complete', [PageController::class, 'scanAndPayComplete'])->name('scanAndPay.complete');

    Route::get('/notification', [NotificationController::class, 'index'])->name('notification');
    Route::get('/notification/detail/{id}', [NotificationController::class, 'show'])->name('notification.detail');
});