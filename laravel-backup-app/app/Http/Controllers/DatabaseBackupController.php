<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Artisan;

class DatabaseBackupController extends Controller
{
    public function backup()
{
    $host = env('DB_HOST', '127.0.0.1');
    $username = env('DB_USERNAME');
    $password = env('DB_PASSWORD');
    $database = env('DB_DATABASE');

    $backupDir = storage_path('app/backups');

    if (!File::exists($backupDir)) {
        File::makeDirectory($backupDir, 0777, true);
    }

    $backupFile = $backupDir . '/' . $database . '_' . now()->format('Y-m-d_H-i-s') . '.sql';

    $command = sprintf(
        'mysqldump --host=%s --user=%s --password=%s %s > %s',
        escapeshellarg($host),
        escapeshellarg($username),
        escapeshellarg($password),
        escapeshellarg($database),
        escapeshellarg($backupFile)
    );

    exec($command, $output, $return_var);

    if ($return_var === 0 && File::exists($backupFile)) {
        return response()->download($backupFile)->deleteFileAfterSend(true);
    } else {
        \Log::error('Database backup failed', ['output' => $output, 'code' => $return_var]);
        return response()->json(['error' => 'Database backup failed. Check logs.'], 500);
    }
}

}
