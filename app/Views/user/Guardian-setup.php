<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">


  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
       <a href="<?= base_url('student-dashboard'); ?>" class="nav-link d-flex align-items-center ">         
          <i class="fas fa-star me-4 fa-lg fa-fw text-secondary"></i> Highlight
        </a>
        <a href="<?= base_url('student-classes'); ?>" class="nav-link d-flex align-items-center ">
          <i class="fas fa-book me-4 fa-lg fa-fw text-secondary"></i> Materials
        </a>
        <a href="<?= base_url('student-progress-report'); ?>" class="nav-link d-flex align-items-center  ">
          <i class="fas fa-chart-line me-4 fa-lg fa-fw text-secondary"></i> Progress Report
        </a>
        <a href="<?= base_url('student-guardiansetup'); ?>" class="nav-link d-flex align-items-center active">
          <i class="fas fa-users me-4 fa-lg fa-fw text-secondary"></i> Guardian Setup
        </a>
        <a href="<?= base_url('student-attendance'); ?>" class="nav-link d-flex align-items-center">
          <i class="fas fa-calendar-check me-4 fa-lg fa-fw text-secondary"></i> Attendance
        </a>
        
        <!-- <a href="<?= base_url('student-interactive-learning'); ?>" class="nav-link d-flex align-items-center ">
          <i class="fa-solid fa-chalkboard me-4 fa-lg fa-fw text-secondary"></i> Interactive Learning
        </a> -->
      </div>
      <div class="mt-auto">
          <hr>
          <span class="fw-bold text-secondary small ms-1">Parent</span>
          <ul class="list-unstyled ms-1 mt-2">
            <a  class="text-decoration-none" href="<?= base_url('/guardian/dashboard/' . esc($student->parent_id)) ?>">
                  <img src="<?= base_url('public/assets/profilepic/' . esc($parentData->parentProfilepic)) ?>" alt="Parent"
                      class="rounded-circle border border-2 me-2" width="25" height="25">
                <span class="text-primary fw-bold"><?= esc($parentData->parentfull_name) ?></span>
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
            <h5 class="text-primary m-0 ms-3 ">Guardian Setup</h5>
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
                data-bs-toggle="dropdown" aria-expanded="false"  onclick="markAsRead(<?= esc($student->user_id) ?>)"
               >
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                <?php if ($unread_announcement > 0): ?>
                <span id="notifBadge"
                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $unread_announcement ?>
                </span>
                <?php endif; ?>
              </a>
               <ul class="dropdown-menu dropdown-menu-end shadow-sm overflow-auto" aria-labelledby="notifDropdown" style="width: 350px; max-height:320px;">
                <li class="dropdown-header fw-bold">Notifications</li>
                <li><hr class="dropdown-divider"></li>

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

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($student->profile_pic)) ?>"
                  alt="Profile Picture" class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2"><?= esc($student->full_name) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('student-profile'); ?>"><i
                      class='fa-solid fa-user me-3 mb-2 text-primary mt-2'></i>Profile</a></li>
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

      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <div class="filler-fluid">
          <h2 class="text-primary mb-4 d-block d-md-none">Guardian Setup</h2>
          <p class="text-muted mb-4 fst-italic border border-dark rounded-1 p-2 pb-3" style="font-size: 0.95rem;">
            *Add <strong>authorized persons</strong> who are allowed to pick up your child from school. Make sure to
            upload a clear 2&times;2 photo and correct relationship.
          </p>
          <?php if (empty($guardians)): ?>
          <p class="text-muted mb-4 fst-italic " style="font-size: 0.95rem;">
            No guardian record found — please add one to continue.
          </p>
          <?php endif; ?>


          <?php if (session()->getFlashdata('success')): ?>
          <script>
            Swal.fire({
              icon: "success",
              title: "Success",
              text: "<?= session()->getFlashdata('success') ?>",
              confirmButtonColor: "#3085d6"
            });
          </script>
          <?php endif; ?>
          


          <!-- Form -->
          <form id="addGuardianForm" action="<?= site_url('user/GuardianSetupPost') ?>" class="row g-3 mb-5"
            method="post" enctype="multipart/form-data">
            <div class="col-md-3">
              <label for="pickupName" class="form-label">First Name</label>
              <input type="text" name="Firstname" id="pickupName" class="form-control"
                style="text-transform: capitalize;" required>
            </div>
            <div class="col-md-3">
              <label for="pickupName" class="form-label">Middle Name</label>
              <input type="text" name="Middlename" id="pickupName" class="form-control"
                style="text-transform: capitalize;" >
            </div>
            <div class="col-md-3">
              <label for="pickupName" class="form-label">Last Name</label>
              <input type="text" name="Lastname" id="pickupName" class="form-control"
                style="text-transform: capitalize;" required>
            </div>
            <div class="col-md-3">
              <label for="relationship" class="form-label">Relationship</label>
              <select name="relationship" id="relationship" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="Mother">Mother</option>
                <option value="Father">Father</option>
                <option value="Guardian">Guardian</option>
                <option value="Sibling">Sibling</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <div class="col-md-3 d-none" id="otherRelationshipDiv">
              <label for="other_relationship" class="form-label">Specify Relationship</label>
              <input type="text" name="other_relationship" id="other_relationship" class="form-control">
            </div>
            <div class="col-md-3">
              <label for="photo" class="form-label">Photo</label>
              <input type="file" name="photo" id="photo" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-3 d-flex align-items-end">
              <button class="btn btn-primary w-100" type="submit">Add Authorized Person</button>
            </div>
          </form>

          <div class="row g-4">
            <?php if (!empty($guardians)): ?>
            <?php foreach ($guardians as $guardian): ?>
            <div class="col-md-3">
              <div id="guardianCard<?= $guardian->guardian_id ?>"
                class="custom-card border border-1 border-dark rounded-2 text-center p-3">
                <div class="school-header text-white bg-primary py-1 rounded-top-2 mb-3">
                  <small class="fw-bold">BRIGHTSIDE GUARDIAN ID</small>
                </div>
                <img src="<?= base_url('public/assets/img/' . ($guardian->photo ?: 'default.jpg')) ?>" alt="Guardian Photo"
                  class="custom-card-img-top rounded p-2 border border-1 border-dark mx-auto mb-3"
                  style="object-fit: cover; height: 180px; width: 180px;">

                <h5 class="fw-semibold"><?= esc($guardian->full_name) ?></h5>
                <hr class='m-0 mb-1 p-0'>
                <p class="text-muted mb-2"><?= esc($guardian->relationship) ?></p>

                <img src="<?= base_url('public/assets/qrcodes/' . $guardian->qr_code) ?>" alt="QR Code"
                  class="img-fluid mb-4 mx-auto" style="width: 140px; height: 140px; object-fit: contain;">
              </div>
              <div class='mt-2 px-4'>
                <form class="removeGuardianForm" action="<?= site_url('guardian/remove/' . $guardian->guardian_id) ?>"
                  method="post">
                  <button type="submit" class="btn btn-danger btn-sm w-100">Remove</button>
                </form>
                <button type="button" class="btn btn-success btn-sm mt-2 w-100 no-capture"
                  onclick="downloadCard('guardianCard<?= $guardian->guardian_id ?>')">
                  Download PNG
                </button>
              </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>No guardians found.</p>
            <?php endif; ?>
          </div>

        </div>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script  src="<?= base_url('dist/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/user.js') ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

  <?php if (empty($guardians)): ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Blocked links
      document.querySelectorAll("a").forEach(link => {
        if (
          !link.href.includes("student-guardiansetup") &&
          !link.href.includes("login")&&
          !link.href.includes("#")&&
          !link.href.includes("/guardian/dashboard/")
        ) {
          link.addEventListener("click", function (e) {
            e.preventDefault();
            Swal.fire({
              icon: "warning",
              title: "Action Not Allowed",
              text: "You must add a guardian before accessing this page.",
              confirmButtonColor: "#3085d6"
            });
          });
        }
      });

      // Blocked buttons
      document.querySelectorAll("button").forEach(btn => {
        if (!btn.closest("form") || btn.type !== "submit") {
          btn.addEventListener("click", function (e) {
            e.preventDefault();
            Swal.fire({
              icon: "warning",
              title: "Action Not Allowed",
              text: "You must add a guardian before performing this action.",
              confirmButtonColor: "#3085d6"
            });
          });
        }
      });
    });
  </script>
  <?php endif; ?>

  <script>
    // Handle "Other" relationship toggle
    const relationshipSelect = document.getElementById('relationship');
    const otherDiv = document.getElementById('otherRelationshipDiv');
    const otherInput = document.getElementById('other_relationship');

    relationshipSelect.addEventListener('change', function () {
      if (this.value === 'Other') {
        otherDiv.classList.remove('d-none');
        otherInput.setAttribute('required', 'required');
      } else {
        otherDiv.classList.add('d-none');
        otherInput.removeAttribute('required');
      }
    });

    // Confirm before adding guardian
    document.getElementById('addGuardianForm').addEventListener('submit', function (e) {
      e.preventDefault();
      Swal.fire({
        title: "Add Authorized Person?",
        text: "Please confirm before submitting.",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, add",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33"
      }).then((result) => {
        if (result.isConfirmed) {
          this.submit();
        }
      });
    });

    // Confirm before removing guardian
    document.querySelectorAll('.removeGuardianForm').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
          title: "Remove Guardian?",
          text: "This action cannot be undone.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, remove",
          cancelButtonText: "Cancel",
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6"
        }).then((result) => {
          if (result.isConfirmed) {
            this.submit();
          }
        });
      });
    });



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
  </script>
</body>
</html>
