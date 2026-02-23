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
        <img  id="schoolLogo"  src="assets/img/logoicon.png" alt="Logo" class="me-3 ms-1" style="width: 38px;">
        <span id="schoolName" class="text-primary fw-bold fs-3">Brightside</span>
      </div>
      <div class="d-flex flex-column align-items-start">
        <hr class="mb-2" />
        <a href="<?= base_url(); ?>admin-dashboard" class="nav-link d-flex align-items-center ">
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
        
         <a href="<?= base_url(); ?>admin-accountManagement" class="nav-link d-flex align-items-center">
          <i class="fas fa-user-gear me-4 fa-lg fa-fw text-secondary"></i> Account Management
        </a>
         
        
        <a href="<?= base_url(); ?>admin-payment" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-money-check-dollar me-4 fa-lg fa-fw text-secondary"></i> Tuition Payment Management
        </a>
        <a href="<?= base_url(); ?>admin-announcement" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-bell me-4 fa-lg fa-fw text-secondary"></i> Announcement
        </a>
       
        <a href="<?= base_url(); ?>admin-settings" class="nav-link d-flex align-items-center active">
          <i class="fas fa-cogs me-4 fa-lg fa-fw text-secondary"></i> Settings 
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
            <!-- Notifications Dropdown -->
            <div class="dropdown me-3 position-relative border-start border-2 ps-3">
              <a href="#" class="text-decoration-none text-primary" id="notifDropdown" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="notifDropdown" style="width: 300px;">
                <li class="dropdown-header fw-bold">Notifications</li>
                <li><hr class="dropdown-divider"></li>
                <li class="px-3 py-2 small text-muted">No new notifications</li>
              </ul>
            </div>

            <!-- Chat Dropdown -->
            <div class="dropdown me-3 position-relative border-start border-2 ps-3">
              <a href="<?= base_url(); ?>admin-chats" class="text-decoration-none text-primary" aria-expanded="false">
                <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
              </a>
            </div>

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($profilePic)) ?>" alt="Profile Image"
                  class="me-2 rounded-circle"
                  style="width: 36px; height: 36px; object-fit: cover;">
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

      <main class="px-4 py-5" style="height: calc(100vh - 56px); overflow-y: auto;">
        <h2 class="mb-4 text-primary fw-bold">Customize Theme & Settings</h2>

       <!-- Theme Colors -->
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white fw-bold border-0">Theme Colors</div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label for="brandcolorPicker" class="form-label fw-semibold">Brand Color</label>
              <input type="color" name="brand_color" id="brandcolorPicker" class="form-control form-control-color" 
                    value="<?= esc($settings['brand_color'] ?? '#ff6b6b') ?>" title="Brand Color">
            </div>
            <div class="col-md-4">
              <label for="accentcolorPicker" class="form-label fw-semibold">Accent Color</label>
              <input type="color" name="accent_color" id="accentcolorPicker" class="form-control form-control-color" 
                    value="<?= esc($settings['accent_color'] ?? '#c14444') ?>" title="Accent Color">
            </div>
            <div class="col-md-4">
              <label for="tertiarycolorPicker" class="form-label fw-semibold">Tertiary Color</label>
              <input type="color" name="tertiary_color" id="tertiarycolorPicker" class="form-control form-control-color" 
                    value="<?= esc($settings['tertiary_color'] ?? '#5a1e1e') ?>" title="Tertiary Color">
            </div>
          </div>
        </div>
      </div>

        <!-- <div class="card shadow-sm border-0 mb-4">
          <div class="card-header bg-primary text-white fw-bold border-0">School Year</div>
          <div class="card-body">
            <label for="schoolYearSelect" class="form-label fw-semibold">Select School Year</label>
            <select id="schoolYearSelect" class="form-select">
              <option selected disabled>Choose School Year</option>
              <option value="2022-2023">2022-2023</option>
              <option value="2023-2024">2023-2024</option>
              <option value="2024-2025">2024-2025</option>
            </select>
          </div>
        </div> -->

        <!-- School Information -->
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-header bg-secondary text-white fw-bold border-0">School Information</div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="schoolNameInput" class="form-label fw-semibold">School Name</label>
                <input type="text" id="schoolNameInput" class="form-control" value="Brightside">
              </div>
              <div class="col-md-6">
                <label for="schoolLogoInput" class="form-label fw-semibold">School Logo</label>
                <input type="file" id="schoolLogoInput" class="form-control" accept="image/*">
              </div>
            </div>
          </div>
        </div>

        <!-- Notification & Admission Settings -->
        <form id="settingsForm" action="<?= base_url('settings/customize') ?>" method="post">
          <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-tertiary text-white fw-bold border-0">Notification & Admission Settings</div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-check form-switch">
                    <input name="sms" class="form-check-input bg-primary border-0" type="checkbox" id="smsToggle"
                      <?= isset($settings['sms_enabled']) && $settings['sms_enabled'] ? 'checked' : '' ?>>
                    <label class="form-check-label fw-semibold" for="smsToggle">Enable SMS Notifications</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-check form-switch">
                    <input name="email" class="form-check-input bg-primary border-0" type="checkbox" id="emailToggle"
                      <?= isset($settings['email_enabled']) && $settings['email_enabled'] ? 'checked' : '' ?>>
                    <label class="form-check-label fw-semibold" for="emailToggle">Enable Email Notifications</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-check form-switch">
                    <input name="admission_status" class="form-check-input bg-primary border-0" type="checkbox"
                      id="admissionToggle" <?= $status === 'open' ? 'checked' : '' ?>>
                    <label class="form-check-label fw-semibold" for="admissionToggle">Admission Open</label>
                  </div>
                </div>
                 <div class="col-md-6">
                  <!-- <div class="form-check form-switch">
                   <button type="button" class="btn btn-primary" onclick="window.location.href='<?= base_url(); ?>admin-add-admin-account'">
                    Add acount Admin account
                   </button>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </form>
        

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end gap-2 mt-3">
          <button class="btn btn-primary" onclick="submitAndApplyTheme()">Apply Settings</button>
          <button class="btn btn-outline-secondary" onclick="reset()">Reset to Default</button>
        </div>
      </main>
    </div>
  </div>

  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom Admin JS -->
  <script src="assets/js/admin.js"></script>

  <script>
    function submitAndApplyTheme() {
      Swal.fire({
        title: 'Apply Theme & Save Settings?',
        text: "Your theme and settings will be saved.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Save',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#ff6b6b',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (result.isConfirmed) {
          applyTheme(); // Run theme logic
          document.getElementById('settingsForm').submit(); // Submit settings form
        }
      });
    }

    function reset() {
      Swal.fire({
        title: 'Reset Theme & Save Settings?',
        text: "Your theme and settings will be reset to default.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Reset',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#ff6b6b',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (result.isConfirmed) {
          resetTheme(); // Run theme logic
          document.getElementById('settingsForm').submit(); // Submit settings form
        }
      });
    }
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
