<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseBackupController;
use App\Http\Controllers\UserBackupController;

Route::get('/', function () {
    return view('welcome');
});

// Admin-only backup system
Route::prefix('backup')->group(function () {
    Route::get('/', [DatabaseBackupController::class, 'showBackupPage'])->name('backup');
    Route::get('/create', [DatabaseBackupController::class, 'backup'])->name('backup.create');
    Route::get('/download/{filename}', [DatabaseBackupController::class, 'downloadBackup'])->name('backup.download');
    Route::get('/clean', [DatabaseBackupController::class, 'cleanBackups'])->name('backup.clean');
});


Route::get('/user-backup', [UserBackupController::class, 'showForm'])->name('public.backup.form');
Route::post('/user-backup', [UserBackupController::class, 'handleBackup'])->name('public.backup.handle');

