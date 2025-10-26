<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); include __DIR__ . '/../layout/header.php'; ?>
<h3>Voting</h3>
<form method="post" action="/vote">
  <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
  <?php foreach($byPosition as $position => $cands): ?>
    <div class="card mb-3">
      <div class="card-header"><strong><?= htmlspecialchars($position) ?></strong></div>
      <div class="card-body">
        <?php foreach($cands as $c): ?>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="votes[<?= htmlspecialchars($position) ?>]" value="<?= $c['id'] ?>" id="cand<?= $c['id'] ?>">
            <label class="form-check-label" for="cand<?= $c['id'] ?>">
              <?= htmlspecialchars($c['name']) ?> <small>(<?= htmlspecialchars($c['course']) ?>)</small>
            </label>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>
  <button class="btn btn-primary" onclick="return confirm('Submit your votes? This cannot be changed.')">Submit Vote</button>
</form>
<?php include __DIR__ . '/../layout/footer.php'; ?>
