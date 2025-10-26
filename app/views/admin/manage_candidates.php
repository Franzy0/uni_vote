<!DOCTYPE html>
<html>
<head>
    <title>Manage Candidates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
<div class="container mt-5">
    <h2 class="text-success mb-4">👤 Manage Candidates</h2>
    <form method="POST" action="/admin/add_candidate" class="mb-4">
        <div class="row">
            <div class="col-md-3"><input name="name" class="form-control" placeholder="Name" required></div>
            <div class="col-md-3"><input name="position" class="form-control" placeholder="Position" required></div>
            <div class="col-md-3"><input name="party" class="form-control" placeholder="Party" required></div>
            <div class="col-md-3"><button class="btn btn-success w-100">Add</button></div>
        </div>
    </form>

    <table class="table table-dark table-striped">
        <tr><th>Name</th><th>Position</th><th>Party</th><th>Action</th></tr>
        <?php foreach ($candidates as $c): ?>
            <tr>
                <td><?= $c['name'] ?></td>
                <td><?= $c['position'] ?></td>
                <td><?= $c['party'] ?></td>
                <td><a href="/admin/delete_candidate/<?= $c['id'] ?>" class="btn btn-danger btn-sm">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="/admin/dashboard" class="btn btn-outline-light">Back</a>
</div>
</body>
</html>
