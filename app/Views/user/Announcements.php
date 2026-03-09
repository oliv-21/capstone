<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Highlights</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css') ?>">
  <link href="../../assets/img/logoicon.png" rel="icon" />

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">

  <style>
    /* Masonry layout */
    .masonry {
      column-count: 3;
      column-gap: 1.5rem;
    }

    .masonry-item {
      break-inside: avoid;
      margin-bottom: 1.5rem;
    }

    /* Image */
    .highlight-img {
      width: 100%;
      height: 250px;
      /* Static height */
      object-fit: cover;
      /* Keeps image looking good */
      display: block;
      cursor: pointer;
      transition: 0.2s ease;
    }

    .highlight-img:hover {
      opacity: 0.9;
    }

    /* Fullscreen Modal */
    .image-modal {
      display: none;
      position: fixed;
      z-index: 2000;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .image-modal img {
      max-width: 95%;
      max-height: 95%;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }
  </style>

</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 min-vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img src="<?= base_url('assets/img/logoicon.png') ?>" alt="Logo" class="me-3 ms-1" style="width: 38px;">
        <span class="text-primary fw-bold fs-3">Brightside</span>
      </div>
      <div class="d-flex flex-column align-items-start">
        <hr class="mb-2" />
        <a href="<?= base_url('student-dashboard'); ?>" class="nav-link d-flex align-items-center active">
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
      <div class="mt-auto mb-3">
        <hr>
        <span class="fw-bold text-secondary small ms-1">Parent</span>
        <ul class="list-unstyled ms-1 mt-2">
          <a class="text-decoration-none" href="<?= base_url('/guardian/dashboard/' . esc($student->parent_id)) ?>">
            <img src="<?= base_url('public/assets/profilepic/' . esc($parentData->parentProfilepic)) ?>" alt="Parent"
              class="rounded-circle border border-2 me-2" width="25" height="25">
            <span class="text-primary fw-bold">
              <?= esc($parentData->parentfull_name) ?>
            </span>
          </a>
        </ul>
      </div>
    </nav>

    <div class="main col-md-10">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>
          <div class="text-primary m-0 ms-3 d-none d-md-block">
            <h5 class="text-primary m-0 ms-3 ">Child Highlight</h5>
          </div>
          <?php 
            $hasUnread = false;
            if (!empty($notification)) {
                foreach ($notification as $n) {
                    if ($n['is_read'] == 0) {
                        $hasUnread = true;
                        break; 
                    }
                }
            }
            ?>

          <div class="d-flex align-items-center ms-auto py-1">
            <div class="dropdown me-3 position-relative border-start border-2 ps-3 ">
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false" onclick="markAsRead(<?= esc($student->user_id) ?>)">
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                <?php if ($unread_announcement > 0): ?>
                <span id="notifBadge"
                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $unread_announcement ?>
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
                  <strong>
                    <?= esc($n['title']) ?>
                  </strong><br>
                  <span class="text-muted">
                    <?= esc($n['message']) ?>
                  </span>
                </li>
                <?php endforeach; ?>
                <?php else: ?>
                <li class="px-3 py-2 small text-muted">No new notifications</li>
                <?php endif; ?>
              </ul>
            </div>

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($student->profile_pic)) ?>"
                  alt="Profile Picture" class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2">
                  <?= esc($student->full_name) ?>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('student-profile'); ?>"><i
                      class='fa-solid fa-user me-3 mb-2 text-primary mt-2'></i>Profile</a></li>

                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item text-danger" href="<?= base_url(); ?>login">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <?php if (!empty($highlight)): ?>
          <?php 
            // 1️⃣ GROUP HIGHLIGHTS BY DATE
            $grouped = [];
            foreach ($highlight as $photo) {
              $date = date("F j, Y", strtotime($photo['created_at']));
              $grouped[$date][] = $photo;
            }
            // 2️⃣ SORT DATES (NEWEST → OLDEST)
            uksort($grouped, function($a, $b) {
              return strtotime($b) - strtotime($a);
            });
          ?>

          <?php foreach ($grouped as $date => $photos): ?>
            <!-- DATE HEADER -->
            <div  class='border-bottom border-2 mb-3 mt-4'>
              <h5 class="fw-bold text-primary ">📸 <?= $date ?></h5>
            </div>

            <!-- Bootstrap responsive row -->
            <div class="row g-3 mb-4">
              <?php foreach ($photos as $photo): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                  <div class="card shadow-sm border-0 rounded-4 overflow-hidden h-100">
                    <img src="<?= base_url('public/assets/highlight/' . esc($photo['photo'])) ?>" 
                        alt="Highlight" class="card-img-top" style="height: 200px; object-fit: cover;"
                        onclick="openImageModal(this.src)">
                    <div class="card-body p-3">
                      <p class="fw-semibold text-dark mb-0">
                        <?= esc($photo['comment']) ?: 'No description provided.' ?>
                      </p>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>

        <?php else: ?>
          <!-- If no highlights -->
          <div class="text-center mt-5">
            <i class="fa-regular fa-image fa-3x text-muted mb-3"></i>
            <p class="text-muted">No highlight photos uploaded yet.</p>
          </div>
        <?php endif; ?>
      </main>



      <!-- FULLSCREEN IMAGE MODAL -->
      <div id="imageModal" class="image-modal" onclick="closeImageModal()">
        <img id="modalImage">
      </div>




    </div>
  </div>

  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>
  <!-- Bootstrap JS -->
  <script src="<?= base_url('dist/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/user.js') ?>"></script>
  <!-- SweetAlert2 CSS & JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
  <?php if (session()->getFlashdata('error')): ?>
    Swal.fire({
      icon: 'error',
      title: 'Warning',
      text: '<?= session()->getFlashdata('error'); ?>',
      confirmButtonColor: '#d33'
    });
  <?php endif; ?>

  <?php if (session()->getFlashdata('success')): ?>
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
</script>

<script>
  function openImageModal(src) {
    document.getElementById("modalImage").src = src;
    document.getElementById("imageModal").style.display = "flex";
  }

  function closeImageModal() {
    document.getElementById("imageModal").style.display = "none";
  }
</script>



</body>

</html>