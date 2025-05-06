<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Public Database Backup</title>
    <style>
        body {
            background: #f0f4f8;
            font-family: sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            color: #3B7DDD;
            margin-bottom: 20px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #4A89DC;
            color: white;
            border: none;
        }
        button:hover {
            background: #3B7DDD;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Backup Your MySQL Database</h2>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('public.backup.handle') }}" method="POST">
        @csrf
        <input type="text" name="host" placeholder="Database Host (e.g., 127.0.0.1)" required>
        <input type="text" name="port" placeholder="Port (e.g., 3306)" value="3306" required>
        <input type="text" name="database" placeholder="Database Name" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password (optional)">
        <button type="submit">Generate Backup</button>
    </form>
</div>
</body>
</html>
