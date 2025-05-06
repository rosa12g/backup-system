
<!DOCTYPE html>
<html>
<head>
    <title>Database Backup</title>
</head>
<body>
    <h1>Backup Database</h1>
    <form action="{{ route('database.backup') }}" method="GET">
        <button type="submit">Download Backup</button>
    </form>
</body>
</html>
