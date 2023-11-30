<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

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
Route::redirect('/', 'login');

Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/deposit', [TransactionController::class, 'showDepositForm'])->name('deposit');
    Route::post('/deposit', [TransactionController::class, 'deposit'])->name('deposit');

    Route::get('/withdraw', [TransactionController::class, 'showWithdrawForm'])->name('withdraw');
    Route::post('/withdraw', [TransactionController::class, 'withdraw'])->name('withdraw');

    Route::get('/transfer', [TransactionController::class, 'showTransferForm'])->name('transfer');
    Route::post('/transfer', [TransactionController::class, 'transfer'])->name('transfer');

    Route::get('/statement', [TransactionController::class, 'showStatement'])->name('statement');
    // Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
