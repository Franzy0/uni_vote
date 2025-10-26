<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); include __DIR__ . '/../layout/header.php'; ?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card p-4">
      <h4 class="mb-3">Login</h4>
      <form method="post" action="/auth/login">
        <div class="mb-3">
          <label>Student ID</label>
          <input class="form-control" name="student_id" required>
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input type="password" class="form-control" name="password" required>
        </div>
        <div class="mb-3">
          <?php $cfg = require __DIR__ . '/../../config/config.php'; if(!empty($cfg['recaptcha']['site_key'])): ?>
            <div class="g-recaptcha" data-sitekey="<?= $cfg['recaptcha']['site_key'] ?>"></div>
          <?php endif; ?>
        </div>
        <button class="btn btn-primary w-100">Login</button>
      </form>
      <div class="mt-2"><small>No account? <a href="/auth/register">Register</a></small></div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
