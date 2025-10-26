<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); include __DIR__ . '/../layout/header.php'; ?>
<h3>Election Results</h3>
<a class="btn btn-outline-success mb-3" href="/admin/results/export?format=csv">Export CSV</a>
<a class="btn btn-outline-success mb-3" href="/admin/results/export?format=pdf">Export PDF</a>

<table class="table table-bordered">
<thead><tr><th>Candidate</th><th>Position</th><th>Votes</th></tr></thead>
<tbody>
<?php foreach($tally as $r): ?>
  <tr><td><?= htmlspecialchars($r['name']) ?></td><td><?= htmlspecialchars($r['position']) ?></td><td><?= (int)$r['votes'] ?></td></tr>
<?php endforeach; ?>
</tbody>
</table>
<?php include __DIR__ . '/../layout/footer.php'; ?>
