<?php // header.php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
$cfg = require __DIR__ . '/../../config/config.php';
?><!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>University Voting</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
  <div class="container">
    <a class="navbar-brand" href="<?= $cfg['base_url'] ?>">Uni Voting</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['admin'])): ?>
          <li class="nav-item"><a class="nav-link" href="/admin">Admin</a></li>
          <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
        <?php elseif(isset($_SESSION['voter'])): ?>
          <li class="nav-item"><a class="nav-link" href="/vote">Vote</a></li>
          <li class="nav-item"><a class="nav-link" href="/results">Results</a></li>
          <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
  <?php if(!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>
  <?php if(!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if(!empty($_SESSION['info'])): ?>
    <div class="alert alert-info"><?= $_SESSION['info']; unset($_SESSION['info']); ?></div>
  <?php endif; ?>
