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
        
         <a href="<?= base_url(); ?>admin-accountManagement" class="nav-link d-flex align-items-center">
          <i class="fas fa-user-gear me-4 fa-lg fa-fw text-secondary"></i> Account Management
        </a>
        
        <a href="<?= base_url(); ?>admin-payment" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-money-check-dollar me-4 fa-lg fa-fw text-secondary"></i> Tuition Payment Management
        </a>
        <a href="<?= base_url(); ?>admin-announcement" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-bell me-4 fa-lg fa-fw text-secondary"></i> Announcement
        </a>
       
        <a href="<?= base_url(); ?>admin-settings" class="nav-link d-flex align-items-center">
          <i class="fas fa-cogs me-4 fa-lg fa-fw text-secondary"></i> Settings 
        </a>

         
          <!-- <a href="admin/getAdminDetails" class="nav-link d-flex align-items-center">
            <i class="fas fa-clipboard-list me-4 fa-lg fa-fw text-secondary"></i> Audit Log
          </a> -->


      </div>
    </nav>

    <div class="main col-md-10">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4 p-1">

        <div class="container-fluid">
          

          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>
          
          <?php
          $unreadCount = 0;
          if (!empty($notification)) {
              foreach ($notification as $n) {
                  if ($n['is_read'] == 0) {
                      $unreadCount++;
                  }
              }
          }
          ?>
          
          <div class="d-flex align-items-center ms-auto py-1">
            <select id="school_year" class="form-select">

              <?php foreach ($yearsRecord as $r): ?>
                <option value="<?= $r['id'] ?>" 
                  <?= ($r['id'] == $selectedOpeningId) ? 'selected' : '' ?>>
                  <?= $r['school_year'] ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div class="dropdown me-3 position-relative border-start border-2 ps-3">
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false"
                onclick="markAsRead(<?= esc($user_id) ?>)">
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                <?php if ($unreadCount > 0): ?>
                <span id="notifBadge"
                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $unreadCount ?>
                </span>
                <?php endif; ?>
              </a>

              <ul class="dropdown-menu dropdown-menu-end shadow-sm overflow-auto" aria-labelledby="notifDropdown"
                style="width: 350px; max-height:320px;">
                <li class="dropdown-header fw-bold">Notifications</li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <?php if (!empty($notification)): ?>
                <?php foreach ($notification as $n): ?>
                <li class="px-3 py-2 small">
                  <strong><?= esc($n['title']) ?></strong><br>
                  <span class="text-muted"><?= esc($n['message']) ?></span>
                </li>
                <?php endforeach; ?>
                <?php else: ?>
                <li class="px-3 py-2 small text-muted">No new notifications</li>
                <?php endif; ?>
              </ul>
            </div>


            <!-- Chat Dropdown -->
            <div class="me-3 position-relative border-start border-2 ps-3">
              <a href="<?= base_url(); ?>admin-chats" class="text-decoration-none text-primary">
                <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
              </a>
            </div>

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($profilepic)) ?>" alt="Profile Image" class="me-2 rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                <span class="fw-bold ms-2">Admin</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('adminProfile'); ?>"><i class='fa-solid fa-user me-3 mb-3 text-primary mt-2'></i>Profile</a></li>
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

    <main class="px-4 py-4 bg-light" style="height: calc(100vh - 56px); overflow-y: auto;">
      <!-- Dashboard Header -->
      <div class="bg-primary bg-gradient text-white p-4 rounded-4 mb-4 shadow-sm">
        <h2 class="fw-bold mb-1">Welcome Back, Admin 👋</h2>
        <p class="mb-0 opacity-75">Here’s a quick summary of Brightside’s activities today.</p>
      </div>

      <!-- Dashboard Cards -->
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                  style="width: 60px; height: 60px;">
                <i class="fa-solid fa-user-graduate fa-lg text-light"></i>
              </div>
              <div>
                <h6 class="fw-semibold text-secondary mb-1">Total Students Enrolled</h6>
                <h3 class="fw-bold text-dark mb-0"><?= $total_students ?></h3>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex align-items-center">
              <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" 
                  style="width: 60px; height: 60px;">
                <i class="fa-solid fa-file-signature fa-lg"></i>
              </div>
              <div>
                <h6 class="fw-semibold text-secondary mb-1">Total Admission Applicants</h6>
                <h3 class="fw-bold text-dark mb-0"><?= $total_applicants ?></h3>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex align-items-center">
              <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" 
                  style="width: 60px; height: 60px;">
                <i class="fa-solid fa-school fa-lg"></i>
              </div>
              <div>
                <h6 class="fw-semibold text-secondary mb-1">Active Classes</h6>
                <h3 class="fw-bold text-dark mb-0"><?= $active_classes ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="mt-5">
        <div class="card-header">
          <h4 class="fw-bold text-light mb-2 bg-primary p-2 rounded-3 shadow-sm">
            <i class="fa-solid fa-clock-rotate-left me-2"></i>Recent Activity
          </h4>
        </div>
        
        <div class="card border-0 shadow-sm rounded-4">
          <ul class="list-group list-group-flush" style="max-height: 270px; overflow-y: auto;">
            <?php if (!empty($recent_activities)): ?>
              <?php foreach ($recent_activities as $activity): ?>
                <li class="list-group-item bg-light py-3 small"><?= esc($activity->activity_text) ?></li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="list-group-item text-muted py-3">No recent activities.</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </main>


    </div>
  </div>

  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/admin.js"></script>
  <script>
    <?php if(session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Warning',
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
    
    
    function markAsRead(userId) {
      fetch("<?= base_url('notifications/markAsRead/') ?>" + userId)
        .then(response => {
          if (response.ok) {
            const badge = document.getElementById('notifBadge');
            if (badge) badge.style.display = 'none';
          }
        });
    }


  document.getElementById('school_year').addEventListener('change', function () {
      let selectedId = this.value;

      if (!selectedId) return; // ignore placeholder

      fetch("<?= base_url('/set-opening-id'); ?>", {
          method: "POST",
          headers: {
              "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "id=" + selectedId
      })
      .then(response => response.json())
      .then(data => {
          if (data.status === 'success') {
              location.reload();
          }
      });
  });
  </script>


</body>

</html>