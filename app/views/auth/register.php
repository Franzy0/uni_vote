<!DOCTYPE html>
<html>
<head>
    <title>Register - University Voting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #191414;
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 400px;
            margin-top: 70px;
            background: #1DB954;
            border-radius: 20px;
            padding: 25px;
            color: #000;
        }
        input, select {
            border-radius: 12px !important;
        }
        .btn-register {
            background-color: #000;
            color: #1DB954;
            border-radius: 20px;
            font-weight: bold;
        }
        .btn-register:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h3><b>🗳 Register Voter</b></h3>
        <form method="POST" action="/auth/register" class="mt-4">
            <input type="text" name="fullname" class="form-control mb-3" placeholder="Full Name" required>
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <select name="year_level" class="form-control mb-3" required>
                <option value="">Select Year Level</option>
                <option>1st Year</option>
                <option>2nd Year</option>
                <option>3rd Year</option>
                <option>4th Year</option>
            </select>
            <button type="submit" class="btn btn-register w-100">REGISTER</button>
        </form>
        <p class="mt-3 text-dark">Already have an account? <a href="/auth/login">Login</a></p>
        <?php if (isset($error)) echo "<div class='text-danger mt-2'>$error</div>"; ?>
    </div>
</body>
</html>
