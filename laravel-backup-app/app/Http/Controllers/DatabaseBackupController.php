<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\View;

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
            File::makeDirectory($backupDir, 0755, true); 
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

   
    public function showBackupPage()
    {
        $backups = [];
        $backupDir = storage_path('app/backups');

        if (File::exists($backupDir)) {
            $files = File::files($backupDir);
            
            foreach ($files as $file) {
                $backups[] = [
                    'name' => $file->getFilename(),
                    'size' => round($file->getSize() / 1024 / 1024, 2), // MB
                    'date' => date('Y-m-d H:i:s', $file->getMTime())
                ];
            }

            // Sort by newest first
            usort($backups, function($a, $b) {
                return strcmp($b['date'], $a['date']);
            });
        }

        return view('backups.ui', [
            'backups' => $backups,
            'lastBackup' => count($backups) > 0 ? $backups[0]['date'] : 'Never'
        ]);
    }

    public function downloadBackup($filename)
    {
        $file = storage_path('app/backups/'.$filename);
        
        if (!File::exists($file)) {
            abort(404);
        }

        return response()->download($file);
    }

    public function cleanBackups()
    {
        $backupDir = storage_path('app/backups');
        $files = File::files($backupDir);
        
       
        if (count($files) > 5) {
            $filesToDelete = array_slice($files, 0, count($files) - 5);
            File::delete($filesToDelete);
            return back()->with('success', 'Old backups cleaned successfully!');
        }

        return back()->with('info', 'No backups to clean.');
    }
    public function viewBackup($filename)
{
    $file = storage_path('app/backups/'.$filename);
    
    if (!File::exists($file)) {
        abort(404);
    }

  
    $preview = shell_exec('head -n 1000 '.escapeshellarg($file));
    
    return view('backups.view', [
        'filename' => $filename,
        'content' => $preview ?: file_get_contents($file),
        'fullSize' => File::size($file)
    ]);
}
}
