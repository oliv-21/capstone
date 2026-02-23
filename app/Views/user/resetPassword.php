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
  <link rel="stylesheet" href="assets/css/user.css">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 min-vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img src="assets/img/logoicon.png" alt="Logo" class="me-3 ms-1" style="width: 38px;">
        <span class="text-primary fw-bold fs-3">Brightside</span>
      </div>
      <div class="d-flex flex-column align-items-start">
        <hr class="mb-2" />
        <a href="<?= base_url('student-dashboard'); ?>" class="nav-link d-flex align-items-center ">         
          <i class="fas fa-star me-4 fa-lg fa-fw text-secondary"></i> Highlight
        </a>
        <a href="<?= base_url('student-classes'); ?>" class="nav-link d-flex align-items-center ">
          <i class="fas fa-book me-4 fa-lg fa-fw text-secondary"></i> Materials
        </a>
        <a href="<?= base_url('student-progress-report'); ?>" class="nav-link d-flex align-items-center  ">
          <i class="fas fa-chart-line me-4 fa-lg fa-fw text-secondary"></i> Progress Report
        </a>
        <a href="<?= base_url('student-guardiansetup'); ?>" class="nav-link d-flex align-items-center">
          <i class="fas fa-users me-4 fa-lg fa-fw text-secondary"></i> Guardian Setup
        </a>
        <a href="<?= base_url('student-attendance'); ?>" class="nav-link d-flex align-items-center">
          <i class="fas fa-calendar-check me-4 fa-lg fa-fw text-secondary"></i> Attendance
        </a>
        
        <!-- <a href="<?= base_url('student-interactive-learning'); ?>" class="nav-link d-flex align-items-center ">
          <i class="fa-solid fa-chalkboard me-4 fa-lg fa-fw text-secondary"></i> Interactive Learning
        </a> -->
      </div>
    </nav>

    <div class="main col-md-10">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid d-flex justify-content-between">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>
          <div class="text-primary m-0 ms-3 d-none d-md-block">
            <h5 class="text-primary m-0 ms-3 ">Reset Password</h5>
          </div>

          <div class="d-flex align-items-center ms-auto py-1">
            <a href="#" class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-bell fa-lg fa-fw" ></i>
            </a>


            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                 <img  src="<?= base_url('public/assets/profilepic/' . esc($student->profile_pic)) ?>"  alt="Profile Picture"
                    class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2"><?= esc($student->full_name) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('student-profile'); ?>"><i class='fa-solid fa-user me-3 mb-2 text-primary mt-2'></i>Profile</a></li>
                <li><hr class="dropdown-divider"></li>
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
        </div>
      </nav>

      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <h2 class="text-primary mb-4 d-block d-md-none">Reset Password</h2>
        <div class="row justify-content-center">
          <div class="col-lg-8 col-md-8">
            <div class="card shadow-sm border-0 p-4">
              <h4 class="text-primary fw-semibold mb-5"><i class='fa-solid fa-key text-primary me-3'></i>Change Password</h4>
              <?= csrf_field() ?>
              <form action="<?= base_url('reset-password'); ?>" method="post">
                <!-- Current Password -->
                <div class="mb-3">
                  <label for="currentPassword" class="form-label fw-semibold">Current Password*</label>
                  <input type="password" class="form-control" id="currentPassword" name="current_password"  required>
                </div>

                <!-- New Password -->
                <div class="mb-3">
                  <label for="newPassword" class="form-label fw-semibold">New Password*</label>
                  <input type="password" class="form-control" id="newPassword" name="new_password" required>
                </div>

                <!-- Confirm New Password -->
                <div class="mb-4">
                  <label for="confirmPassword" class="form-label fw-semibold">Confirm New Password*</label>
                  <input type="password" class="form-control" id="confirmPassword" name="confirm_password"  required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Change Password</button>
              </form>
            </div>
            <!-- Message Modal -->
            <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <?= session()->get('success') ?? session()->get('error') ?? '' ?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </main>

    </div>
  </div>

  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/user.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Check if there's a success or error message
    const successMsg = "<?= session()->get('success') ?>";
    const errorMsg = "<?= session()->get('error') ?>";

    if (successMsg || errorMsg) {
      const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
      messageModal.show();
    }
  });
</script>

</body>

</html>