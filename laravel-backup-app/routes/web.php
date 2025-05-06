<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseBackupController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/database-backup', [DatabaseBackupController::class, 'backup'])->name('database.backup');
Route::view('/backup-ui', 'backup');
