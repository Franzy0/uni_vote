<!DOCTYPE html>
<html>
<head>
    <title>Vote Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white text-center p-5">
    <h2 class="text-success">✅ <?= $message ?? 'Vote Submitted Successfully!' ?></h2>
    <a href="/auth/logout" class="btn btn-light mt-4">Logout</a>
</body>
</html>
