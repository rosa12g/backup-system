<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Backup System</title>
    <style>
        :root {
            --cream: #FFF8F0;
            --sky-blue: #4A89DC;
            --dark-blue: #3B7DDD;
        }
        
        body {
            background-color: var(--cream);
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
            color: var(--dark-blue);
            text-align: center;
            margin-bottom: 30px;
        }
        
        .btn {
            background-color: var(--sky-blue);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }
        
        .btn:hover {
            background-color: var(--dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(74, 137, 220, 0.3);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .backup-list {
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        
        .backup-item {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            border-bottom: 1px solid #f5f5f5;
        }
        
        .backup-item:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Database Backup System</h1>
        
        <div class="actions">
            <a href="/backup/create" class="btn">Create New Backup</a>
            <a href="/backup/clean" class="btn" style="margin-left: 10px;">Clean Old Backups</a>
        </div>
        
        <div class="backup-list">
            <h3>Recent Backups:</h3>
            
            @foreach($backups as $backup)
            <div class="backup-item">
                <span>{{ $backup['name'] }}</span>
                <span>{{ $backup['size'] }} MB</span>
                <a href="/backup/download/{{ $backup['name'] }}" class="btn" style="padding: 6px 12px;">Download</a>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>