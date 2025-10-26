<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>University Voting</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
  <div class="container">
    <a class="navbar-brand" href="/">Uni Voting</a>
    <div class="ms-auto">
      <?php if(!empty($_SESSION['admin'])): ?>
        <a class="btn btn-outline-primary btn-sm" href="/admin">Admin</a>
      <?php elseif(!empty($_SESSION['voter'])): ?>
        <a class="btn btn-outline-primary btn-sm" href="/vote">Vote</a>
      <?php else: ?>
        <a class="btn btn-outline-primary btn-sm" href="/auth/login">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container">
  <?php if($msg = Utils::flash('error')): ?>
    <div class="alert alert-danger"><?= $msg ?></div>
  <?php endif; ?>
  <?php if($msg = Utils::flash('success')): ?>
    <div class="alert alert-success"><?= $msg ?></div>
  <?php endif; ?>
  <?php if($msg = Utils::flash('info')): ?>
    <div class="alert alert-info"><?= $msg ?></div>
  <?php endif; ?>
