<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <!-- Favicon -->
  <link href="assets/img/logoicon.png" rel="icon" />

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  
  <!-- bootstrap link -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css">

  <!-- Customized Bootstrap Stylesheet -->
  <link rel="stylesheet" href="assets/css/website.css">
</head>

<body class="loginBody">

  <!-- Navbar Start -->
   <div class="container-fluid bg-light position-relative shadow">
    <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
      <a href="<?= base_url('/') ?>" class="navbar-brand">
        <img class="logo" src="assets/img/logo.png" alt="" style="width: 230px;">
      </a>
      <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
        <div class="navbar-nav fw-bold fs-5 mx-auto py-0 ">
          <a href="<?= base_url('/') ?>" class="nav-item nav-link ">Home</a>
          <a class="nav-link" href="<?= base_url(); ?>about">About</a>
          <a href="<?= base_url(); ?>classes" class="nav-item nav-link">Classes</a>
          <!-- <a href="<?= base_url(); ?>teacher" class="nav-item nav-link">Teachers</a> -->
          <a href="<?= base_url(); ?>contact" class="nav-item nav-link">Contact</a>
        </div>
        <a href="<?= base_url(); ?>login" class="btn btn-secondary px-5 fw-bold text-white ">Login</a>
      </div>
    </nav>
  </div>
  <!-- Navbar End -->

  <div class="container-fluid login-container" style="height: calc(100vh - 90px);">
    <div class="login-card">
      <h3 class="text-primary">Welcome to Brightside</h3>

      <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?= session()->getFlashdata('error'); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      <?php endif; ?>

      <?php if (session()->get('validation')): ?>
          <div class="alert alert-warning">
              <?= session()->get('validation')->listErrors(); ?>
          </div>
      <?php endif; ?>
      
      <?php if (session()->get('intraction')): ?>
          <div class="alert alert-warning">
              <?= session()->get('intraction'); ?>
          </div>
      <?php endif; ?>

      <?php if (session()->get('successful')): ?>
          <div class="alert alert-success">
              <?= session()->get('successful'); ?>
          </div>
      <?php endif; ?>

      <form method="post" action="<?= base_url(); ?>loginPost">
        <!-- Username -->
        <div class="mb-3 input-group">
          <span class="input-group-text bg-secondary border-end-0">
            <i class="fas fa-user text-white"></i>
          </span>
          <input type="text" class="form-control border-start-0" id="email" placeholder="Username" required name="username" value="<?= old('username') ?>"/>
        </div>

        <!-- Password -->
        <div class="mb-3 input-group">
          <span class="input-group-text bg-secondary border-end-0">
            <i class="fas fa-lock text-white"></i>
          </span>
          <input type="password" class="form-control border-start-0" id="password" placeholder="Password" required name="password" />
        </div>

        <div class="mb-4 text-end">
          <a href="<?= base_url(); ?>resetPassword" class="text-decoration-none text-secondary">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 text-white">Login</button>

        <!-- Signup link -->
        <div class="text-center mt-3">
          <small>Don’t have an account? <a href="<?= base_url(); ?>signup" class="text-decoration-none text-primary fw-bold">Sign Up</a></small>
        </div>
      </form>
    </div>
  </div>

  <script src="dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
