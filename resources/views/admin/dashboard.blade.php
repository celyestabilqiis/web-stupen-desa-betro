<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin Desa Betro</title>
</head>
<body>
    <main>
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, {{ auth()->user()->name }}.</p>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </main>
</body>
</html>
