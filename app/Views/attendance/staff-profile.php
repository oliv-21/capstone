<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />


  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css">

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="assets/css/admin.css">
  <meta name="csrf-token" content="<?= csrf_hash() ?>">

</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->


    <div class="main col-md-12">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid">
  
          <h4 class="text-primary m-0 fw-bold ps-2">Attendance Monitoring</h4>
          <div class="dropdown ms-auto">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
              id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
               <img src="<?= base_url('public/assets/profilepic/' . esc($profileAccount['profile_pic'])) ?>" alt="Parent"  class="me-2 rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
              <span class="fw-bold ms-2"><?= esc($profileAccount['full_name']) ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="<?= base_url('staffprofile'); ?>"><i class='fa-solid fa-user me-3 mb-3 text-primary mt-2'></i>Profile</a></li>
              <li>
                <form action="<?= base_url('logout') ?>" method="post" class="d-inline">
                      <?= csrf_field() ?>
                      <button type="submit" class="dropdown-item text-danger">
                          <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                      </button>
                  </form>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <main class="px-4 py-4">
       <!-- Profile Update Card -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-primary text-white">
            <i class="fa-solid fa-user me-2"></i> Edit Profile
          </div>
          <div class="card-body">
            <form action="<?= base_url('staff/updateProfile') ?>" method="post" enctype="multipart/form-data">
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Email Address</label>
                  <input type="email" name="email" class="form-control" value="<?= esc($email) ?>" required>
                </div>

                <div class="col-md-6">
                  <?php if (!empty($profilepic)) : ?>
                    <label class="form-label fw-semibold">Current Profile Image</label><br>
                    <img src="<?= base_url('public/assets/profilepic/' . $profilepic) ?>" alt="Profile Picture" width="120" class="rounded mb-2">
                  <?php endif; ?>
                  <input type="file" name="profile_image" class="form-control" accept="image/*">
                </div>
              </div>

              <div class="text-end">
                <button type="submit" class="btn btn-success px-4">
                  <i class="fa-solid fa-floppy-disk me-2"></i>Save Changes
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Password Change Card -->
        <div class="card shadow-sm">
          <div class="card-header bg-info text-white">
            <i class="fa-solid fa-key me-2"></i> Change Password
          </div>
          <div class="card-body">
            <form action="<?= base_url('staff/chage-password') ?>" method="post" id="changePasswordForm">
              <div class="row g-3 mb-3">
                <div class="col-md-4">
                  <label class="form-label fw-semibold">Current Password</label>
                  <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold">New Password</label>
                  <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold">Confirm New Password</label>
                  <input type="password" name="confirm_password" class="form-control" required>
                </div>
              </div>

              <div class="text-end">
                <button type="submit" class="btn btn-warning text-white px-4">
                  <i class="fa-solid fa-rotate me-2"></i>Change Password
                </button>
              </div>
            </form>
          </div>
        </div>
      </main>
    </div>
  </div>


  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/admin.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  

</body>

</html>