<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Create a database backup';

    public function handle()
    {
        // Get database credentials
        $host = config('database.connections.mysql.host');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $database = config('database.connections.mysql.database');

        // Validate credentials
        if (empty($host) || empty($username) || empty($database)) {
            $this->error('Database configuration is incomplete');
            return 1;
        }

        // Create backup directory if needed
        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        // Generate filename
        $backupFile = $backupDir.'/'.$database.'_'.now()->format('Y-m-d_His').'.sql';

        // Build command
        $command = sprintf(
            'mysqldump --host=%s --user=%s --password=%s %s > %s',
            escapeshellarg($host),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($backupFile)
        );

        // Execute command
        $process = Process::fromShellCommandline($command);
        $process->run();

        // Handle results
        if (!$process->isSuccessful()) {
            $error = sprintf(
                "Backup failed with code %d: %s",
                $process->getExitCode(),
                $process->getErrorOutput()
            );
            $this->error($error);
            Log::error($error);
            return 1;
        }

        $this->info('Backup created successfully: '.$backupFile);
        Log::info('Database backup created: '.$backupFile);
        return 0;
    }
}