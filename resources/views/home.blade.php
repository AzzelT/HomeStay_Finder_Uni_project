<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - HomeStay Finder</title>
</head>
<body>

    <h1>Welcome to HomeStay Finder</h1>

    @auth
        <h2>Hello, {{ auth()->user()->name }}!</h2>

        <p>You are successfully logged in.</p>

        <p>
            <a href="{{ route('login') }}">Login</a>
        </p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @endauth

</body>
</html>