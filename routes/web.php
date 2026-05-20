<?php

use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [BorrowingController::class, 'index'])->name('dashboard');

    // Katalog & Peminjaman
    Route::get('/katalog', [ItemController::class, 'index'])->name('items.index');
    Route::post('/pinjam', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::post('/kembalikan/{borrowing}', [BorrowingController::class, 'returnItem'])->name('borrowings.return');

    // Settings
    Route::get('/pengaturan', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/pengaturan/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');

    // Admin Routes
    Route::middleware('isAdmin')->group(function () {
        // CRUD Alat
        Route::post('/alat', [ItemController::class, 'store'])->name('items.store');
        Route::put('/alat/{item}', [ItemController::class, 'update'])->name('items.update');
        Route::post('/alat/{item}/maintenance', [ItemController::class, 'toggleMaintenance'])->name('items.maintenance');
        
        // Manajemen Mahasiswa
        Route::get('/admin/mahasiswa', [StudentController::class, 'index'])->name('admin.students.index');
        Route::get('/admin/mahasiswa/{student}', [StudentController::class, 'show'])->name('admin.students.show');
        Route::post('/admin/mahasiswa/{student}/suspend', [StudentController::class, 'toggleSuspend'])->name('admin.students.suspend');
        Route::post('/admin/mahasiswa/{student}/reset-password', [StudentController::class, 'resetPassword'])->name('admin.students.reset-password');
    });
});

require __DIR__.'/auth.php';