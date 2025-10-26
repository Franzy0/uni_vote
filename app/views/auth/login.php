<!DOCTYPE html>
<html>
<head>
    <title>Login - University Voting System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #191414;
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 400px;
            margin-top: 100px;
            background: #1DB954;
            border-radius: 20px;
            padding: 25px;
            color: #000;
        }
        input {
            border-radius: 12px !important;
        }
        .btn-login {
            background-color: #000;
            color: #1DB954;
            border-radius: 20px;
            font-weight: bold;
        }
        .btn-login:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h3><b>🎧 Student Voting Login</b></h3>
        <form method="POST" action="/auth/login" class="mt-4">
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button type="submit" class="btn btn-login w-100">LOGIN</button>
        </form>
        <p class="mt-3 text-dark">Don’t have an account? <a href="/auth/register">Register</a></p>
        <?php if (isset($error)) echo "<div class='text-danger mt-2'>$error</div>"; ?>
    </div>
</body>
</html>
