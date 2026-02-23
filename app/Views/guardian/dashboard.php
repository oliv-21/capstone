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
  <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css') ?>">

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">

  <style>
    .welcome-box {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
      padding: 30px;
      max-width: 700px;
      margin: 40px auto;
    }

    .welcome-box h4 {
      font-weight: 700;
    }

    .btn {
      border-radius: 30px;
      padding: 10px 20px;
    }

    .alert {
      border-radius: 12px;
      font-size: 0.95rem;
    }

    .child-card {
      background: #fff;
      border: 1px solid #e0e7ff;
      border-radius: 16px;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .child-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 12px rgba(0, 0, 0, 0.1);
    }

    .child-card img {
      border: 3px solid #ff6b6b;
    }

    .child-card h6 {
      font-weight: 700;
    }

    .badge {
      padding: 0.5em 1em;
      border-radius: 20px;
    }

    @media (max-width: 768px) {
      .welcome-box {
        margin: 20px;
        padding: 20px;
      }
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 min-vh-100 d-flex flex-column">
      <?php
        $hasChildren = !empty($childrens) && count($childrens) > 0;
      ?>

      <div>
        <div class="d-flex align-items-center mb-2 mt-3">
          <img src="<?= base_url('assets/img/logoicon.png') ?>" alt="Logo" class="me-3 ms-1" style="width: 38px;">
          <span class="text-primary fw-bold fs-3">Brightside</span>
        </div>

        <div class="d-flex flex-column align-items-start">
          <hr class="mb-2" />
          <a href="<?= base_url('guardian/dashboard'); ?>" class="nav-link d-flex align-items-center active <?= !$hasChildren ? 'disabled-link' : '' ?>">
            <i class="fas fa-child me-4 fa-lg fa-fw text-secondary"></i>
            Admission
          </a>
          <a href="<?= base_url('/guardian-announcement/' . esc($students->user_id)); ?>"
            class="nav-link d-flex align-items-center <?= !$hasChildren ? 'disabled-link' : '' ?>">
              <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i>
              <?php if ($unread_announcement > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $unread_announcement ?>
                </span>
              <?php endif; ?>
              Announcement
          </a>
 
          <a href="<?= base_url('/payment-history/' . esc($students->user_id)); ?> "
            class="nav-link d-flex align-items-center <?= !$hasChildren ? 'disabled-link' : '' ?>">
            <i class="fa-solid fa-money-bill me-4 fa-lg fa-fw text-secondary"></i>
            Payment
          </a>
        </div>
      </div>

      <!-- Children Section -->
      <div class="mt-5">
        <hr>
        <span class="fw-bold text-secondary small ms-1">Children</span>
        <ul class="list-unstyled ms-1 mt-2">
          <?php if (!empty($childrens)): ?>
          <?php foreach ($childrens as $child): ?>
          <li class="dropdown-item-text d-flex align-items-center mt-2">
            <a href="<?= base_url('/StudentviewDashboard/' . $child->admission_id) ?>"
              class="d-flex align-items-center text-decoration-none">
              <img src="<?= base_url('public/assets/profilepic/' . esc($child->profile_pic)) ?>" alt="Child"
                class="rounded-circle border border-2 me-2" width="25" height="25">
              <span class="text-primary fw-bold"><?= esc($child->full_name) ?></span>
            </a>
          </li>
          <?php endforeach; ?>
          <?php else: ?>
          <li class="dropdown-item-text text-muted">No children found.</li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>

    <!-- Main Section -->
    <div class="main col-md-10">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>

          <div class="text-primary m-0 ms-3 d-none d-md-block">
            <h5 class="text-primary m-0 ms-3">Admission</h5>
          </div>

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


            <!-- Notifications -->
            <div class="dropdown me-3 position-relative border-start border-2 ps-3">
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false"
                onclick="markAsRead(<?= esc($students->user_id) ?>)">
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

            <!-- Chat -->
            <a href="<?= base_url(); ?>student-chat"
              class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
            </a>

            <!-- Profile Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($students->profile_pic)) ?>"
                  alt="Profile Picture" class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2"><?= esc($students->full_name) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('guardian-Profile'); ?>"><i
                      class="fa-solid fa-user me-3 mb-2 text-primary mt-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="<?= base_url('guardian-resetPassword'); ?>"><i
                      class="fa-solid fa-key me-3 mb-2 text-primary mt-2"></i>Reset Password</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
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

      <!-- Main Content -->
      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <?php if ($isAdmissionOpen): ?>
        
        <div class="p-4 text-center rounded-4 shadow-sm mb-4" 
            style="background: linear-gradient(135deg, #fff5f5, #ffecec); border-left: 6px solid #ff6b6b;">
          <h5 class="fw-bold text-danger mb-1">Welcome to Brightside, <?= esc($guardian->full_name) ?>! 👋</h5>
          <p class="text-muted mb-0">Let’s begin your child’s exciting journey for the upcoming school year.</p>
        </div>
        
        <?php else: ?>
        <div class="welcome-box text-center p-5 rounded-4 shadow-lg bg-white mt-4">
          <h2 class="fw-bold text-primary mb-3">
            <i class="fas fa-hand-wave text-warning me-2"></i>
            Welcome back, <?= esc($guardian->full_name) ?>!
          </h2>
          <p class="text-muted fs-5 mb-0">
            We're happy to have you here. Explore your dashboard to manage your profile and your child's information.
          </p>
        </div>
        <?php endif; ?>

        <?php if ($isAdmissionOpen): ?>
        <?php if (!empty($student)): ?>
        <div class="children-section text-center">
          <h5 class="text-primary fw-bold mb-4">Your Children</h5>
          <div class="row justify-content-center">
            <?php foreach ($student as $child): ?>
            <div class="col-md-4 col-sm-6 mb-4">
              <div class="child-card p-4 text-center">
                <img
                  src="<?= base_url('public/assets/profilepic/' . (!empty($child->picture) ? esc($child->picture) : 'default.webp')) ?>"
                  class="rounded-circle mb-3" width="90" height="90" alt="Child Profile">
                <h6 class="mb-1"><?= esc($child->full_name) ?></h6>
                <?php
                  $statusColors = [
                    'Pending' => 'bg-danger',
                    'Approved' => 'bg-success',
                    'Disapproved' => 'bg-danger',
                    'Enrolled' => 'bg-success',
                    'Pre-enrollee' => 'bg-success',
                    'Interview Failed' => 'bg-danger',
                  ];
                  $status = $child->status ?? 'Pending';
                  $badgeClass = $statusColors[$status] ?? 'bg-secondary';
                ?>
                <span class="badge <?= $badgeClass ?>"><?= esc($status) ?></span>
                <div class="mt-3">
                  <?php if (($child->status ?? 'Pending') === 'Enrolled'): ?>
                  <a href="<?= base_url('/StudentviewDashboard/' . $child->admission_id) ?>"
                    class="btn btn-primary btn-sm">View Dashboard</a>
                  <?php endif; ?>
                  <a href="<?= base_url('/Studentview/' . $child->admission_id) ?>"
                    class="btn btn-outline-info btn-sm ms-1">View</a>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <a href="<?= base_url('/guardian-admission'); ?>" class="btn btn-outline-success mt-3">
            <i class="fa-solid fa-user-plus me-2"></i>Add New Admission
          </a>

        </div>
        <?php else: ?>
        <div class="text-center mt-4">
          <a href="<?= base_url('/guardian-admission'); ?>" class="btn btn-outline-success mt-3">
            <i class="fa-solid fa-user-plus me-2"></i>Add New Admission
          </a>
        </div>
        <?php endif; ?>
        <?php endif; ?>
      </main>
    </div>
  </div>
  

  <!-- Sidebar Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="<?= base_url('dist/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/user.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    
    // Mark notifications as read
    function markAsRead(userId) {
      fetch("<?= base_url('notifications/markAsRead/') ?>" + userId)
        .then(response => {
          if (response.ok) {
            const badge = document.getElementById('notifBadge');
            if (badge) badge.style.display = 'none';
          }
        });
    }

    // Disabled links warning
    document.addEventListener('DOMContentLoaded', () => {
      const disabledLinks = document.querySelectorAll('.disabled-link');
      disabledLinks.forEach(link => {
        link.addEventListener('click', (e) => {
          e.preventDefault(); // Prevent navigation
          Swal.fire({
            icon: 'warning',
            title: 'Please wait!',
            text: 'Please finish your enrollment first.',
            timer: 2000,
            showConfirmButton: false
          });
        });
      });
    });

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
