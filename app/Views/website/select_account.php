<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Forgot Password - Brightside</title>
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
            <a href="" class="navbar-brand">
                <img class="logo" src="assets/img/logo.png" alt="" style="width: 230px;">
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav fw-bold fs-5 mx-auto py-0">
                    <a href="<?= base_url('/') ?>" class="nav-item nav-link active">Home</a>
                    <a class="nav-link" href="<?= base_url(); ?>about">About</a>
                    <a href="<?= base_url(); ?>classes" class="nav-item nav-link">Classes</a>
                    <!-- <a href="<?= base_url(); ?>teacher" class="nav-item nav-link">Teachers</a> -->
                    <a href="<?= base_url(); ?>contact" class="nav-item nav-link">Contact</a>
                </div>
                
                <a href="<?= base_url(); ?>login" class="btn btn-primary px-5 fw-bold text-white ">Login</a>
            </div>
        </nav>
  </div>
  <!-- Navbar End -->

    <!-- Select Account Start -->
    <div class="container-fluid login-container" style="height: calc(100vh - 87px);">
        <div class="login-card">
            <h3 class="text-primary">Select Your Account</h3>
            <p class="mb-4 text-secondary">Choose the account you'd like to reset the password for.</p>

           <form method="post" action="<?= base_url('forgotpassword/getEmail') ?>">
                <div class="mb-4 input-group">
                    <span class="input-group-text bg-secondary border-end-0">
                        <i class="fas fa-user text-white"></i>
                    </span>
                    <select class="form-control border-start-0" name="username" required>
                        <option value="" disabled selected>Select an account</option>
                        <?php foreach ($users as $user): ?>
                            <option   value="<?= esc($user['username']) ?>">
                                <?= esc($user['username']) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                    
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 text-white">Continue</button>
            </form>
            <div class="mt-4 text-center">
                    <a href="<?= base_url(); ?>login" class="text-decoration-none text-secondary">Back to Login</a>
            </div>
        </div>
    </div>


  <script src="dist/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
