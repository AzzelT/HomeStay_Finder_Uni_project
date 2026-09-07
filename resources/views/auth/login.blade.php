<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HomeStay Finder</title>
</head>
<body>

    <h1>HomeStay Finder</h1>

    <h2>Login</h2>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <div>
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
            >
        </div>

        <br>

        <div>
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <br>

        <div>
            <label>
                <input type="checkbox" name="remember">
                Remember me
            </label>
        </div>

        <br>

        <button type="submit">Login</button>
    </form>

    <p>
        <a href="{{ route('password.request') }}">Forgot your password?</a>
    </p>

    <p>
        Don't have an account?
        <a href="{{ route('register') }}">Register</a>
    </p>

</body>
</html>