<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); include __DIR__ . '/../layout/header.php'; ?>
<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="card p-4">
      <h4 class="mb-3">Student Registration</h4>
      <form method="post" action="/auth/register">
        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
        <div class="row">
          <div class="col-md-6 mb-3"><label>Student ID</label><input name="student_id" class="form-control" required></div>
          <div class="col-md-6 mb-3"><label>Full name</label><input name="fullname" class="form-control" required></div>
        </div>
        <div class="mb-3"><label>Email</label><input name="email" type="email" class="form-control" required></div>
        <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
        <div class="mb-3">
          <?php if(!empty($recaptcha_site)): ?>
            <div class="g-recaptcha" data-sitekey="<?= $recaptcha_site ?>"></div>
          <?php endif; ?>
        </div>
        <button class="btn btn-success w-100">Register</button>
      </form>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
