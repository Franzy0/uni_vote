<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); include __DIR__ . '/../layout/header.php'; ?>
<h3>Manage Candidates</h3>

<form method="post" action="/admin/candidates" class="mb-4">
  <div class="row g-2">
    <div class="col-md-3"><input name="name" placeholder="Name" class="form-control" required></div>
    <div class="col-md-3"><input name="position" placeholder="Position" class="form-control" required></div>
    <div class="col-md-3"><input name="course" placeholder="Course" class="form-control"></div>
    <div class="col-md-3"><input name="manifesto" placeholder="Short manifesto" class="form-control"></div>
  </div>
  <div class="mt-2"><button class="btn btn-success">Add Candidate</button></div>
</form>

<table class="table table-striped">
  <thead><tr><th>ID</th><th>Name</th><th>Position</th><th>Course</th><th>Created</th><th>Action</th></tr></thead>
  <tbody>
    <?php foreach($candidates as $c): ?>
    <tr>
      <td><?= $c['id'] ?></td>
      <td><?= htmlspecialchars($c['name']) ?></td>
      <td><?= htmlspecialchars($c['position']) ?></td>
      <td><?= htmlspecialchars($c['course']) ?></td>
      <td><?= $c['created_at'] ?></td>
      <td>
        <form method="post" action="/admin/candidates/delete" onsubmit="return confirm('Delete candidate?')">
          <input type="hidden" name="id" value="<?= $c['id'] ?>">
          <button class="btn btn-danger btn-sm">Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../layout/footer.php'; ?>
