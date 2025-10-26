<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); include __DIR__ . '/../layout/header.php'; ?>
<h3>Election Results</h3>
<?php if(!empty($tally)): ?>
  <canvas id="resultsChart" width="600" height="250"></canvas>
  <table class="table table-bordered mt-3">
    <thead><tr><th>Candidate</th><th>Position</th><th>Votes</th></tr></thead>
    <tbody>
      <?php foreach($tally as $r): ?>
        <tr><td><?= htmlspecialchars($r['name']) ?></td><td><?= htmlspecialchars($r['position']) ?></td><td><?= (int)$r['votes'] ?></td></tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const labels = <?= json_encode(array_map(fn($r)=> $r['name'].' ('.$r['position'].')', $tally)) ?>;
    const data = <?= json_encode(array_map(fn($r)=> (int)$r['votes'], $tally)) ?>;
    new Chart(document.getElementById('resultsChart'), {
      type: 'bar',
      data: { labels, datasets: [{ label: 'Votes', data }] }
    });
  </script>
<?php else: ?>
  <p>No results yet.</p>
<?php endif; ?>
<?php include __DIR__ . '/../layout/footer.php'; ?>
