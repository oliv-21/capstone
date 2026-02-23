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

  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <meta name="csrf-token" content="<?= csrf_hash() ?>">

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
        <a href="<?= base_url(); ?>admin-attendance" class="nav-link d-flex align-items-center active">
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


            <a href="<?= base_url(); ?>admin-chats" class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
            </a>

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

      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <h2 class="mb-4 text-primary">Attendance Monitoring</h2>

        <div
          class="container-fluid  d-flex justify-content-between align-items-center flex-column col-12 flex-md-row ">
          <div class="d-flex align-items-center col-8 col-sm-3">
            <label for="class" class="form-label fw-bold text-secondary me-2 mb-0 fs-5 bg">Class</label>
            <select class="form-select rounded border-secondary" id="class">
             
              <?php foreach ($classes as $class): ?>
                <option value="<?= esc($class['classname']) ?>">
                  <?= esc($class['classname']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          
        </div>
        
        <div class="container-fluid">
          <h4 class="mb-4 text-secondary fw-bold text-center "> Attendance Summary</h4>
        </div>
        <div class="table-responsive">
          <table class="table table-responsive table-hover align-middle" id="membersTable" class="table table-striped table-bordered">
            <thead class="primary-table-header">
              <tr>
                <th>Full Name (Last, First, M.I.)</th>
                <th>Class Level</th>
                <th>Total Days</th>
                <th>Days Attended</th>
                <th>Days Absent</th>
                <th>Attendance Percentage</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($summaries as $summary): ?>
                <tr>
                  <td><?= esc($summary['name']) ?></td>
                  <td><?= esc($summary['class_level']) ?></td>
                  <td><?= esc($summary['total_days']) ?></td>
                  <td><?= esc($summary['present']) ?></td>
                  <td><?= esc($summary['absent']) ?></td>
                  <td><?= esc($summary['percentage']) ?>%</td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Pickup Modal -->
        <div class="modal fade" id="pickupModal" tabindex="-1" aria-labelledby="pickupModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-sm border-0">
              <div class="modal-header border-bottom">
                <h5 class="modal-title text-primary fw-bold" id="pickupModalLabel">Who Will Pick Up the Child?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="pickupForm">
              <div class="modal-body">
                <div class="row g-4 justify-content-center" id="guardianList">
                 <input type="hidden" name="user_id" id="user_id">


                  <!-- Guardians will be injected here -->
                </div>
              </div>
              <div class="modal-footer border-top justify-content-center">
                <button type="submit" class="btn btn-primary px-5 fw-semibold">Confirm Pickup</button>
              </div>
            </form>

            </div>
          </div>
        </div>

      </main>
    </div>
  </div>


  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <!-- <script src="dist/js/bootstrap.bundle.min.js"></script> -->
  <script src="assets/js/admin.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- JS Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


<script>
$(document).ready(function () {
  var table = $('#membersTable').DataTable();

  // Log lahat ng laman ng Class Level column (index 1)
  table.column(1).data().each(function(value, index){
    console.log("Row " + index + " Class Level:", value);
  });

  // // Filter by class when dropdown changes
  // $('#class').on('change', function () {
  //   var selectedClass = $(this).val();
  //   console.log("Selected Class:", selectedClass);

  //   table.column(1).search(selectedClass).draw();
  // });
   $('#class').on('change', function () {
      table.column(1).search(this.value).draw(); // column index 2 = Class
    });

    // ✅ Automatically trigger filter on page load for selected class
    var selectedClass = $('#class').val();
    if(selectedClass){
      table.column(1).search(selectedClass).draw();
    }
});



    // Sidebar Toggle
    function setupSidebarToggle() {
      const sidebar = document.getElementById('adminSidebar');
      const toggle = document.getElementById('sidebarToggle');
      const backdrop = document.getElementById('sidebarBackdrop');
      if (toggle && sidebar && backdrop) {
        toggle.addEventListener('click', () => {
          sidebar.classList.toggle('active');
          backdrop.classList.toggle('show');
        });
        backdrop.addEventListener('click', () => {
          sidebar.classList.remove('active');
          backdrop.classList.remove('show');
        });
      }
    }
    document.addEventListener('DOMContentLoaded', () => {
      setupSidebarToggle();
    });

    // Date and Time
    function updateDateTime() {
      const now = new Date();
      const date = now.toLocaleDateString();
      const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      const dateElement = document.getElementById("date");
      const timeElement = document.getElementById("time");
      if (dateElement) dateElement.textContent = `${date}`;
      if (timeElement) timeElement.textContent = `${time}`;
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();

    // Attendance Logic 
    document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('admissionTable').addEventListener('click', function (e) {
        const row = e.target.closest('tr');
        if (!row) return;

        if (e.target.closest('.arrived-btn')) {
          const userId = row.getAttribute('data-student-id');
          Swal.fire({
            title: 'Child Arrived?',
            text: "Are you sure you want to mark this child as arrived?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Arrived',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#ff6b6b',
            cancelButtonColor: '#5a1e1e'
          }).then((result) => {
            if (result.isConfirmed) {
              const now = new Date();
              const dateStr = now.toISOString().slice(0, 10); // YYYY-MM-DD
              const timeStr = now.toTimeString().slice(0, 8); // HH:MM:SS

              // Send attendance data to backend
              fetch('attendance/mark-arrival', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-Requested-With': 'XMLHttpRequest',
                  'X-CSRF-TOKEN': '<?= csrf_hash() ?>' // if CSRF enabled
                },
                body: JSON.stringify({
                  user_id: userId,
                  date: dateStr,
                  arrival_time: timeStr,
                  status: 'Present'
                })
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  row.querySelector('.arrival-time').textContent = timeStr;
                  const statusBtn = row.querySelector('.status-btn');
                  statusBtn.textContent = 'Present';
                  statusBtn.classList.remove('btn-warning');
                  statusBtn.classList.add('btn-success');
                  row.querySelector('.arrived-btn').disabled = true;
                  row.querySelector('.pickedup-btn').disabled = false;
                  Swal.fire('Arrived!', 'Child has been marked as arrived.', 'success');
                } else {
                  Swal.fire('Error', data.message || 'Failed to mark arrival.', 'error');
                }
              })
              .catch(() => {
                Swal.fire('Error', 'Could not connect to server.', 'error');
              });
            }
          });
        }
      });

    });


  // modal ng pickup
    document.addEventListener("DOMContentLoaded", function () {
      const pickupButtons = document.querySelectorAll(".pickedup-btn");
      const guardianList = document.getElementById("guardianList");
      const pickupForm = document.getElementById("pickupForm");

      // When a Picked Up button is clicked
      pickupButtons.forEach(button => {
        button.addEventListener("click", function () {
          const userId = this.getAttribute("data-user-id");
          document.getElementById('user_id').value = userId;
          document.getElementById('date').value = new Date().toISOString().slice(0, 10);

          guardianList.innerHTML = '<div class="text-center">Loading guardians...</div>';

          fetch(`guardians/${userId}`)
            .then(response => response.json())
            .then(data => {
              guardianList.innerHTML = "";
              if (data.length === 0) {
                guardianList.innerHTML = '<p class="text-center text-muted">No guardians found.</p>';
                return;
              }
              data.forEach((guardian, index) => {
                const radioId = `pickupGuardian${index + 1}`;
                const card = `
                  <div class="col-6 col-md-3 text-center">
                    <input type="radio" class="btn-check" name="pickupPerson" id="${radioId}" value="${guardian.guardian_id}" required>
                    <label class="btn d-flex flex-column align-items-center rounded-1" for="${radioId}" style="cursor: pointer;">
                      <div class="card">
                        <img src="public/assets/img/${guardian.photo || 'default.jpg'}" alt="guardian photo" class="card-img-top" style="object-fit: fill; height: 200px;">
                        <div class="card-body text-center">
                          <h5 class="card-title mb-1 fw-semibold">${guardian.full_name}</h5>
                          <p class="text-muted mb-0">${guardian.relationship}</p>
                          <input type="hidden" name="user_id" id="user_id" value="${guardian.user_id}">
                        </div>
                      </div>
                    </label>
                  </div>`;
                guardianList.insertAdjacentHTML("beforeend", card);
              });
            })
            .catch(error => {
              console.error("Error loading guardians:", error);
              guardianList.innerHTML = '<p class="text-center text-danger">Failed to load guardians.</p>';
            });
        });
      });

      // Handle form submission
      pickupForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const selectedGuardian = document.querySelector('input[name="pickupPerson"]:checked');
        if (!selectedGuardian) {
          Swal.fire('Error', 'Please select who will pick up the child.', 'error');
          return;
        }

        const userId = document.getElementById('user_id').value;

        const leaveTime = new Date().toTimeString().slice(0, 8);
        const guardianId = selectedGuardian.value;
         

        fetch('<?= site_url('attendance/mark-pickup') ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            user_id: userId,
            date: date,
            leave_time: leaveTime,
            guardian_id: guardianId
          })
        })
        .then(res => res.json())
        .then(response => {
          if (response.success) {
            Swal.fire('Success!', 'Pickup recorded successfully.', 'success').then(() => {
              location.reload();
            });
          } else {
            Swal.fire('Error', response.message || 'Failed to record pickup.', 'error');
          }
        })
        .catch(() => {
          Swal.fire('Error', 'Failed to connect to server.', 'error');
        });

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('pickupModal'));
        modal.hide();
      });
    });

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