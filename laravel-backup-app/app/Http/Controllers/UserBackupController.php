<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class UserBackupController extends Controller
{
    public function showForm()
    {
        return view('public-backup-form');
    }

    public function handleBackup(Request $request)
    {
        $validated = $request->validate([
            'host'     => 'required|string',
            'port'     => 'required|string',
            'database' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string',
        ]);

        $fileName = 'backup_' . Str::slug($validated['database']) . '_' . time() . '.sql';
        $filePath = storage_path('app/temp/' . $fileName);

        $command = [
            'mysqldump',
            '-h' . $validated['host'],
            '-P' . $validated['port'],
            '-u' . $validated['username'],
        ];

        if (!empty($validated['password'])) {
            $command[] = '-p' . $validated['password'];
        }

        $command[] = $validated['database'];

        $process = new Process($command);
        $process->run();

        if ($process->isSuccessful()) {
            file_put_contents($filePath, $process->getOutput());
            return response()->download($filePath)->deleteFileAfterSend(true);
        } else {
            return back()->withErrors(['error' => 'Backup failed: ' . $process->getErrorOutput()]);
        }
    }
}

