<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Admin Dashboard — Archived Admissions</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css">
  

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img  id="schoolLogo"  src="assets/img/logoicon.png" alt="Logo" class="me-3 ms-1" style="width: 38px;">
        <span id="schoolName" class="text-primary fw-bold fs-3">Brightside</span>
      </div>
      <div class="d-flex flex-column align-items-start">
        <hr class="mb-2" />
        <a href="<?= base_url(); ?>admin-dashboard" class="nav-link d-flex align-items-center active">
          <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i> Dashboard
        </a>
         
        <a href="<?= base_url(); ?>admin-admission" class="nav-link d-flex align-items-center position-relative">
            <div class="position-relative me-4">
              <i class="fas fa-users fa-lg fa-fw text-secondary"></i>
              <?php if ($unread_count > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $unread_count ?>
                </span>
              <?php endif; ?>
            </div>
            Admission
        </a>

        <a href="<?= base_url(); ?>admin-enrolled" class="nav-link d-flex align-items-center">
          <i class="fas fa-chalkboard-teacher me-4 fa-lg fa-fw text-secondary"></i> Enrolled Students
        </a>
        <a href="<?= base_url(); ?>admin-attendance" class="nav-link d-flex align-items-center">
          <i class="fas fa-calendar-check me-4 fa-lg fa-fw text-secondary"></i> Attendance Summary
        </a>
         <?php if(session()->get('admin_role') === 'Admin'): ?>
         <a href="<?= base_url(); ?>admin-accountManagement" class="nav-link d-flex align-items-center">
          <i class="fas fa-user-gear me-4 fa-lg fa-fw text-secondary"></i> Account Management
        </a>
         <?php endif; ?>
        
        <a href="<?= base_url(); ?>admin-payment" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-money-check-dollar me-4 fa-lg fa-fw text-secondary"></i> Tuition Payment Management
        </a>
        <a href="<?= base_url(); ?>admin-announcement" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-bell me-4 fa-lg fa-fw text-secondary"></i> Announcement
        </a>
        <?php if(session()->get('admin_role') === 'Admin'): ?>
        <a href="<?= base_url(); ?>admin-settings" class="nav-link d-flex align-items-center">
          <i class="fas fa-cogs me-4 fa-lg fa-fw text-secondary"></i> Settings 
        </a>
         <?php endif; ?>
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
            <a href="" class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-bell fa-lg fa-fw"></i>
            </a>
            <a href="<?= base_url(); ?>admin-chats" class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
            </a>

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($profilepic)) ?>" alt="Profile Image"
                  class="me-2 rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                <span class="fw-bold ms-2">Admin</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('adminProfile'); ?>"><i
                      class='fa-solid fa-user me-3 mb-3 text-primary mt-2'></i>Profile</a></li>
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
        <h2 class="text-primary mb-4">
          <i onclick="window.location.href='<?= base_url(); ?>admin-settings'" class="fas fa-arrow-left me-3"></i>Add Admin Account
        </h2>
        <form id="settingsForm" action="<?= base_url('add-admin-account') ?>" method="post" enctype="multipart/form-data">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-tertiary text-white fw-bold border-0">
                    Add Admin Account
                </div>

                <div class="card-body">
                    <div class="row g-3">

                        <!-- Username -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control"
                                  placeholder="Enter username"
                                  value="<?= old('username') ?>" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                  placeholder="Enter email"
                                  value="<?= old('email') ?>" required>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                            <input type="password" id="password" name="password"
                                  class="form-control"
                                  placeholder="Enter password" required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" id="confirmPassword" name="confirm_password"
                                  class="form-control"
                                  placeholder="Confirm password" required>
                        </div>

                        <!-- First Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control"
                                  placeholder="Enter first name"
                                  value="<?= old('first_name') ?>" required>
                        </div>

                        <!-- Middle Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control"
                                  placeholder="Enter middle name"
                                  value="<?= old('middle_name') ?>">
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control"
                                  placeholder="Enter last name"
                                  value="<?= old('last_name') ?>" required>
                        </div>

                        <!-- Profile Picture -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Profile Picture <span class="text-danger">*</span></label>
                            <input type="file" name="profile_pic" class="form-control" accept="image/*">
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary">Add Admin</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>





       
      </main>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script>
document.getElementById('settingsForm').addEventListener('submit', function(e) {
    e.preventDefault(); // stop auto submit

    // Get form values
    const username = document.querySelector("input[name='username']").value.trim();
    const email = document.querySelector("input[name='email']").value.trim();
    const password = document.getElementById('password').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();
    const firstName = document.querySelector("input[name='first_name']").value.trim();
    const lastName = document.querySelector("input[name='last_name']").value.trim();

    // Required fields list
    const requiredFields = [
        { value: username, label: "Username" },
        { value: email, label: "Email" },
        { value: password, label: "Password" },
        { value: confirmPassword, label: "Confirm Password" },
        { value: firstName, label: "First Name" },
        { value: lastName, label: "Last Name" }
    ];

    // Check if any required field is empty
    for (let field of requiredFields) {
        if (field.value === "") {
            Swal.fire({
                icon: 'error',
                title: 'Missing Required Field',
                text: field.label + ' is required.',
            });
            return;
        }
    }

    // Check password match
    if (password !== confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Password Mismatch',
            text: 'Passwords do not match.',
        });
        return;
    }

    // Confirm submission
    Swal.fire({
        title: 'Confirm Submission',
        text: "Are you sure you want to add this admin account?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, add it!'
    }).then((result) => {
        if (result.isConfirmed) {
            e.target.submit(); // Submit if all good
        }
    });
});

// Flashdata Alert System
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
</script>


  </body>
</html>
