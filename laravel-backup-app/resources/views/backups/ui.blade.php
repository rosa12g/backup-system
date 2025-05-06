<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Backup System</title>
    <style>
        body {
            background-color: #FFF8F0; /* Cream background */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        h1 {
            color: #3B7DDD; /* Dark blue */
            text-align: center;
            margin-bottom: 30px;
        }
        
        .btn {
            background-color: #4A89DC; /* Sky blue */
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }
        
        .btn:hover {
            background-color: #3B7DDD; /* Dark blue */
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(74, 137, 220, 0.3);
        }
        
        .backup-list {
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        
        .backup-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid #f5f5f5;
        }
        
        .backup-item:hover {
            background-color: #f9f9f9;
        }
        
        .status {
            margin: 20px 0;
            padding: 15px;
            border-radius: 6px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Database Backup System</h1>
        
        <div class="status">
            <p>Last backup: <strong>{{ $lastBackup }}</strong></p>
        </div>
        
        <div class="actions">
            <a href="{{ route('backup.create') }}" class="btn">Create New Backup</a>
            <a href="{{ route('backup.clean') }}" class="btn" style="margin-left: 10px;">Clean Old Backups</a>
        </div>
        
        <div class="backup-list">
            <h3>Recent Backups:</h3>
            
            @forelse($backups as $backup)
            <div class="backup-item">
                <div>
                    <strong>{{ $backup['name'] }}</strong><br>
                    <small>{{ $backup['date'] }} • {{ $backup['size'] }} MB</small>
                </div>
                <a href="{{ route('backup.download', $backup['name']) }}" class="btn">Download</a>
            </div>
            @empty
            <p>No backups available yet.</p>
            @endforelse
        </div>
    </div>
</body>
</html>