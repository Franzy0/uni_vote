<!DOCTYPE html>
<html>
<head>
    <title>Vote Now</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
<div class="container mt-5">
    <h2 class="text-center text-success mb-4">🗳 Cast Your Vote</h2>
    <form method="POST" action="/vote/submit">
        <?php 
        $grouped = [];
        foreach ($candidates as $c) $grouped[$c['position']][] = $c;
        foreach ($grouped as $position => $list): ?>
            <div class="card bg-secondary mb-3">
                <div class="card-header text-white">
                    <b><?= strtoupper($position) ?></b>
                </div>
                <div class="card-body">
                    <?php foreach ($list as $c): ?>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="votes[<?= $position ?>]" value="<?= $c['id'] ?>" required>
                            <label class="form-check-label"><?= $c['name'] ?> (<?= $c['party'] ?>)</label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-success w-100">Submit Vote</button>
    </form>
</div>
</body>
</html>
