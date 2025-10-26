<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); include __DIR__ . '/../layout/header.php'; ?>
<h3>Admin Dashboard</h3>
<p>
  <a class="btn btn-primary" href="/admin/candidates">Manage Candidates</a>
  <a class="btn btn-outline-primary" href="/admin/results">View Results</a>
  <a class="btn btn-outline-success" href="/admin/results/export?format=csv">Export CSV</a>
  <a class="btn btn-outline-success" href="/admin/results/export?format=pdf">Export PDF</a>
</p>

<?php if(!empty($tally)): ?>
  <canvas id="adminChart" height="120"></canvas>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const labels = <?= json_encode(array_map(fn($r)=> $r['name']." (".$r['position'].")", $tally)) ?>;
    const data = <?= json_encode(array_map(fn($r)=> (int)$r['votes'], $tally)) ?>;
    new Chart(document.getElementById('adminChart'), {
      type: 'pie',
      data: { labels, datasets: [{ data }] }
    });
  </script>
<?php else: ?>
  <p>No candidates yet.</p>
<?php endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>
