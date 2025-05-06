<?php
use App\Http\Controllers\UserBackupController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseBackupController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/database-backup', [DatabaseBackupController::class, 'backup'])->name('database.backup');
Route::view('/backup-ui', 'backup');
Route::get('/public-backup', [UserBackupController::class, 'showForm'])->name('public.backup.form');
Route::post('/public-backup', [UserBackupController::class, 'handleBackup'])->name('public.backup.handle')
Route::prefix('backup')->group(function () {
    Route::get('/', [DatabaseBackupController::class, 'showBackupPage'])->name('backup');
    Route::get('/create', [DatabaseBackupController::class, 'backup'])->name('backup.create');
    Route::get('/download/{filename}', [DatabaseBackupController::class, 'downloadBackup'])->name('backup.download');
    Route::get('/clean', [DatabaseBackupController::class, 'cleanBackups'])->name('backup.clean');
});