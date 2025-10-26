<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
<div class="container mt-5">
    <h2 class="text-success mb-4">🎓 Admin Dashboard</h2>
    <a href="/admin/candidates" class="btn btn-outline-light">Manage Candidates</a>
    <a href="/admin/results" class="btn btn-outline-light">View Results</a>
    <a href="/auth/logout" class="btn btn-danger float-end">Logout</a>

    <hr class="border-light">
    <h5>Total Votes: <?= $total_votes ?></h5>

    <ul class="list-group mt-4">
        <?php foreach ($results as $r): ?>
            <li class="list-group-item bg-secondary text-white">
                <?= $r['name'] ?> (<?= $r['position'] ?>) — <b><?= $r['total_votes'] ?> votes</b>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
