<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HomeStay Finder</title>
</head>
<body>

    <h1>HomeStay Finder</h1>

    <h2>Welcome, {{ auth()->user()->name }}!</h2>

    <p>You are successfully logged in.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
    <p>
    <a href="/profile">Go to Profile</a>
</p>

</body>
</html>