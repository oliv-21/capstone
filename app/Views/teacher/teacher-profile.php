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

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img src="assets/img/logoicon.png" alt="Logo" class="me-3 ms-1" style="width: 38px;">
        <span class="text-primary fw-bold fs-3">Brightside</span>
      </div>
      <div class="d-flex flex-column align-items-start">
        <hr class="mb-2" />
        <a href="<?= base_url(); ?>teacher-dashboard" class="nav-link d-flex align-items-center ">
          <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i> Dashboard
        </a>
        <a href="<?= base_url(); ?>teacher-students" class="nav-link d-flex align-items-center">
          <i class="fas fa-chalkboard-teacher me-4 fa-lg fa-fw text-secondary"></i> Enrolled Students
        </a>
        <a href="<?= base_url(); ?>teacher-grades" class="nav-link d-flex align-items-center">
          <i class="fas fa-calendar-check me-4 fa-lg fa-fw text-secondary"></i> Progress Report
        </a>
        <a href="<?= base_url(); ?>teacher-materials" class="nav-link d-flex align-items-center">
          <i class="fas fa-book me-4 fa-lg fa-fw text-secondary"></i> Materials
        </a>
        <a href="<?= base_url(); ?>teacher-annoucement" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-bell me-4 fa-lg fa-fw text-secondary"></i> Announcements
        </a>
        <a href="<?= base_url(); ?>teacher-dashboard" class="nav-link d-flex align-items-center">
          <i class="fas fa-layer-group me-4 fa-lg fa-fw text-secondary"></i> Subjects
        </a>
      </div>
    </nav>

    <div class="main col-md-10">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>

          <div class="d-flex align-items-center ms-auto py-1">
            <div class="dropdown me-3 position-relative border-start border-2 ps-3 ">
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                <!-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">2</span> -->
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm overflow-auto" aria-labelledby="notifDropdown"
                style="width: 350px; max-height:320px;">
                <li class="dropdown-header fw-bold">Notifications</li>
                <li><hr class="dropdown-divider"></li>
                <li class="px-3 py-2 small">
                  <strong>New Assignment</strong><br>
                  <span class="text-muted">Math worksheet uploaded.</span>
                </li>
                <li class="px-3 py-2 small">
                  <strong>New Message</strong><br>
                  <span class="text-muted">Parent sent a message.</span>
                </li>
              </ul>
            </div>
            <div class="me-3 position-relative border-start border-2 ps-3">
              <a href="<?= base_url(); ?>teacher-chats" class="text-decoration-none text-primary">
                <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
              </a>
            </div>

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($profilepic)) ?>" alt="Profile Image" class="me-2 rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                
               <span class="fw-bold ms-2"><?= esc($teacher['lastname']) ?></span>

              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('teacherProfile-info'); ?>"><i class='fa-solid fa-user me-3 mb-3 text-primary mt-2'></i>Profile Info</a></li>
                <li><a class="dropdown-item" href="<?= base_url('teacherProfile'); ?>"><i class='fa-solid fa-lock me-3 mb-3 text-primary mt-2'></i>forget Password</a></li>
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
       



        <!-- Password Change Card -->
        <div class="card shadow-sm">
          <div class="card-header bg-info text-white">
            <i class="fa-solid fa-key me-2"></i> Change Password
          </div>
          <div class="card-body">
            <form id="changePasswordForm" action="<?= base_url('teacherChangePassword') ?>" method="post">
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
  

  <script>
    // SweetAlert confirmation for Update Profile
    document.getElementById('updateProfileForm').addEventListener('submit', function (e) {
      e.preventDefault();
      Swal.fire({
        title: 'Save Changes?',
        text: "Do you want to update your profile information?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Save',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (result.isConfirmed) {
          e.target.submit();
        }
      });
    });

    // SweetAlert confirmation for Change Password
    document.getElementById('changePasswordForm').addEventListener('submit', function (e) {
      e.preventDefault();
      Swal.fire({
        title: 'Change Password?',
        text: "Are you sure you want to update your password?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Change',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#ffc107',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (result.isConfirmed) {
          e.target.submit();
        }
      });
    });
  </script>
  <script>
document.addEventListener("DOMContentLoaded", function() {
    <?php if(session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session()->getFlashdata('error'); ?>',
            confirmButtonColor: '#d33'
        });
    <?php endif; ?>

    <?php if(session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?= session()->getFlashdata('success'); ?>',
            confirmButtonColor: '#3085d6'
        });
    <?php endif; ?>
});

document.getElementById('profileInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePreview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>


</body>
</html>
