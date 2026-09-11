<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - HomeStay Finder</title>
</head>
<body>

    <h1>My Profile</h1>

    <p>Name: {{ auth()->user()->name }}</p>
    <p>Email: {{ auth()->user()->email }}</p>

    <p>
        <a href="/dashboard">Back to Dashboard</a>
    </p>

</body>
</html>