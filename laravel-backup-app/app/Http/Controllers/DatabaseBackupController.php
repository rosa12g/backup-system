<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Artisan;

class DatabaseBackupController extends Controller
{
    public function backup()
    {
     
        $host = env('DB_HOST', 'localhost');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');

        
        $backupDir = storage_path('app/backups');

        
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0777, true);
        }

 
        $backupFile = $backupDir . '/' . $database . '_' . now()->format('Y-m-d_H-i-s') . '.sql';

       
        $command = "mysqldump --host=$host --user=$username --password=$password $database > $backupFile";

        exec($command, $output, $return_var);

      
        if ($return_var === 0) {
         
            return response()->download($backupFile);
        } else {
            
            return response()->json(['error' => 'Error occurred during backup!'], 500);
        }
    }
}
