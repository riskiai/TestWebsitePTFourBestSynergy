<?php

use App\Http\Controllers\Admin\QueuesAdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Customer\QueuesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

/* Data Login */
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login-prosess', [LoginController::class, 'loginProsess'])->name('loginProsess');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Data Pengambilan Tiket
Route::get('/form-tiket', [QueuesController::class, 'formTiket'])->name('formTiket');
Route::post('/form-tiketProsess', [QueuesController::class, 'formTiketProsess'])->name('formTiketProsess');
Route::post('/check-no-polisi', [QueuesController::class, 'checkNoPolisi'])->name('checkNoPolisi');
Route::get('/print-ticket/{id}', [QueuesController::class, 'printTicket'])->name('printTicket');

/* Data Antrian Berdasarkan Jenis GR DAN BP */
Route::get('data-antrian', [QueuesController::class, 'getDataAntrian'])->name('dataAntrian');

// Data Admin
Route::middleware(['auth', \App\Http\Middleware\UserAccess::class . ':admin'])->group(function () {
    Route::get('/dashboard', [QueuesAdminController::class, 'dashboard'])->name('dashboard');

    /* Data Tiket */
    Route::get('/datatiketcustomer', [QueuesAdminController::class, 'datatiketcustomer'])->name('datatiketcustomer');
    Route::delete('/delete-tiket', [QueuesAdminController::class, 'deleteTiket'])->name('deletedatatiket');

    /* Data Antrian */
    Route::get('/data-antrianadmin', [QueuesAdminController::class, 'index'])->name('dataantrianAdmine');
    Route::post('/complete-antrian', [QueuesAdminController::class, 'completeAntrian'])->name('completeantrian');
    Route::delete('/delete-antrian', [QueuesAdminController::class, 'deleteAntrian'])->name('deleteantrian');
    Route::get('/generate-pdf-antrian/{id}', [QueuesAdminController::class, 'generatePDF'])->name('generatepdfantrian');
});
