<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Teacher Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>
  <div class="wrapper d-flex">
    <!-- Sidebar -->
    <nav id="teacherSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img id="schoolLogo" src="assets/img/logoicon.png" alt="Logo" class="me-3 ms-1" style="width: 38px;">
        <span id="schoolName" class="text-primary fw-bold fs-3">Brightside</span>
      </div>
      <div class="d-flex flex-column align-items-start">
        <hr class="mb-2" />
        <a href="<?= base_url(); ?>teacher-dashboard" class="nav-link d-flex align-items-center active">
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
        <a href="<?= base_url(); ?>teacher-interactive-learning" class="nav-link d-flex align-items-center">
          <i class="fas fa-layer-group me-4 fa-lg fa-fw text-secondary"></i> Interactive Learning
        </a>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="main col-md-10">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4 p-1">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>

          <div class="d-flex align-items-center ms-auto py-1">
            <select id="school_year" class="form-select">

              <?php foreach ($yearsRecord as $r): ?>
                <option value="<?= $r['id'] ?>" 
                  <?= ($r['id'] == $selectedOpeningId) ? 'selected' : '' ?>>
                  <?= $r['school_year'] ?>
                </option>
              <?php endforeach; ?>
            </select>


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
            <!-- Notification Dropdown -->


            <div class="dropdown me-3 position-relative border-start border-2 ps-3">
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false"
                onclick="markAsRead(<?= esc($teacher['user_id']) ?>)">
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

            <div class="me-3 position-relative border-start border-2 ps-3">
              <a href="<?= base_url(); ?>teacher-chats" class="text-decoration-none text-primary">
                <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
              </a>
            </div>

            <!-- Profile Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($profilepic)) ?>" alt="Profile Image" class="me-2 rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                
               <span class="fw-bold ms-2"><?= esc($teacher['lastname']) ?></span>

              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('teacherProfile-info'); ?>"><i class='fa-solid fa-user me-3 mb-3 text-primary mt-2'></i>Profile Info</a></li>
                <li><a class="dropdown-item" href="<?= base_url('teacherProfile'); ?>"><i class='fa-solid fa-lock me-3 mb-3 text-primary mt-2'></i>forget Password</a></li>
                <li><form action="<?= base_url('logout') ?>" method="post" class="d-inline">
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

      <!-- Page Content -->
      <main class="px-4 py-4 bg-light" style="height: calc(100vh - 56px); overflow-y: auto;">
        <!-- Dashboard Header -->
        <div class="bg-primary bg-gradient text-white p-4 rounded-4 mb-4 shadow-sm">
          <h2 class="fw-bold mb-1">Welcome Back, <?= esc($teacher['lastname']) ?> 👋</h2>
          <p class="mb-0 opacity-75">Here’s a quick summary of Brightside’s activities today.</p>
        </div>

        
        <!-- Dashboard Cards -->
        <div class="row g-4">
          <div class="col-md-4">
            <a href="<?= base_url('teacher-students') ?>" class="text-decoration-none">
              <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                  <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                      style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-user-graduate fa-lg text-light"></i>
                  </div>
                  <div>
                    <h6 class="fw-semibold text-secondary mb-1">Total Students Enrolled</h6>
                    <h3 class="fw-bold text-dark mb-0"> <?= esc($dashboardCount['total_students'] ?? 0) ?></h3>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-4">
            <a href="<?= base_url('teacher-materials') ?>" class="text-decoration-none">
              <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                  <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" 
                      style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-file-signature fa-lg"></i>
                  </div>
                  <div>
                    <h6 class="fw-semibold text-secondary mb-1">Total Material</h6>
                    <h3 class="fw-bold text-dark mb-0"><?= esc($dashboardCount['total_material'] ?? 0) ?></h3>
                  </div>
                </div>
              </div>
            </a>
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

  <!-- Sidebar Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script >
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
