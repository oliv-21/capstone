<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <!-- Favicon -->
  <link href="<?= base_url('assets/img/logoicon.png'); ?>" rel="icon" />

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  
  <!-- Bootstrap -->
  <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css'); ?>">

  <!-- Custom Styles -->
  <link rel="stylesheet" href="<?= base_url('assets/css/website.css'); ?>">
</head>

<body class="loginBody">

  <!-- Navbar Start -->
  <div class="container-fluid bg-light position-relative shadow">
    <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
      <a href="<?= base_url('/') ?>" class="navbar-brand">
        <img class="logo" src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo" style="width: 230px;">
      </a>
      <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
        <div class="navbar-nav fw-bold fs-5 mx-auto py-0">
          <a href="<?= base_url('/') ?>" class="nav-item nav-link">Home</a>
          <a href="<?= base_url('about') ?>" class="nav-item nav-link">About</a>
          <a href="<?= base_url('classes') ?>" class="nav-item nav-link">Classes</a>
          <!-- <a href="<?= base_url('teacher') ?>" class="nav-item nav-link">Teachers</a> -->
          <a href="<?= base_url('contact') ?>" class="nav-item nav-link">Contact</a>
        </div>
        <a href="<?= base_url('login') ?>" class="btn btn-secondary px-5 fw-bold text-white">Login</a>
      </div>
    </nav>
  </div>
  <!-- Navbar End -->

  <!-- Account Confirmation Section -->
  <div class="container-fluid login-container d-flex align-items-center justify-content-center" style="height: calc(100vh - 90px);">
    <div class="login-card text-center p-4 shadow rounded bg-white" style="max-width: 400px; width: 100%;">
      <h3 class="text-primary mb-4">Is this your account?</h3>

      <!-- User Image -->
      <div class="mb-3">
        <img src="<?= base_url('public/assets/profilepic/' . ($guardianData['profile_pic'] ?? 'default.webp')); ?>" 
             alt="Profile" 
             class="rounded-circle border border-3 border-primary"
             style="width: 120px; height: 120px; object-fit: cover;">
      </div>
        <h5 class="fw-bold mb-4">Email: <?= esc($user['email'] ?? 'Unknown User'); ?></h5>

      <!-- Username -->
      <h5 class="fw-bold mb-4">Username: <?= esc($user['username'] ?? 'Unknown User'); ?></h5>

      <!-- Login Form -->
      <form method="post" action="<?= base_url('loginPost'); ?>">
        <input type="hidden" name="username" value="<?= esc($user['username'] ?? ''); ?>">

        <!-- Password Field -->
        <div class="mb-3 input-group">
          <span class="input-group-text bg-secondary border-end-0">
            <i class="fas fa-lock text-white"></i>
          </span>
          <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="Password" required>
        </div>

        <div class="mb-4 text-end">
          <a href="<?= base_url('resetPassword'); ?>" class="text-decoration-none text-secondary">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 text-white fw-bold">Login</button>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="<?= base_url('dist/js/bootstrap.bundle.min.js'); ?>"></script>

</body>
</html>
