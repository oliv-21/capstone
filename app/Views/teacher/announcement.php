<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Announcement</title>
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
  <link href="assets/img/logoicon.png" rel="icon" />
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
        <a href="<?= base_url(); ?>teacher-annoucement" class="nav-link d-flex align-items-center active">
          <i class="fa-solid fa-bell me-4 fa-lg fa-fw text-secondary"></i> Announcements
        </a>
        <a href="<?= base_url(); ?>teacher-interactive-learning" class="nav-link d-flex align-items-center">
          <i class="fas fa-layer-group me-4 fa-lg fa-fw text-secondary"></i> Interactive Learning
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
                <li>  <a class="dropdown-item text-danger" href="<?= base_url(); ?>login">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="text-primary">Announcements</h2>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
            <i class="fas fa-plus me-2"></i>New Announcement
          </button>
        </div>

        <!-- Announcements Table -->
        <div class="table-responsive rounded">
          <table class="table table-hover table-bordered bg-white">
              <thead class="primary-table-header">
                  <tr>
                      <th scope="col">#</th>
                      <th scope="col">Title</th>
                      <th scope="col">Message</th>
                      <th scope="col">Date Posted</th>
                      <th scope="col">Actions</th>
                  </tr>
              </thead>
              <tbody>
                  <?php if (!empty($announcements)): ?>
                      <?php $i = 1; foreach ($announcements as $a): ?>
                          <tr>
                              <th scope="row"><?= $i++ ?></th>
                              <td><?= esc($a->title) ?></td>
                              <td><?= esc($a->message) ?></td>
                              <td><?= date('F j, Y', strtotime($a->created_at)) ?></td>
                              <td>
                                  <!-- Edit Button -->
                                  <button 
                                      class="btn btn-sm btn-secondary me-2" 
                                      data-bs-toggle="modal" 
                                      data-bs-target="#editModal"
                                      data-id="<?= $a->id ?>"
                                      data-title="<?= esc($a->title) ?>"
                                      data-message="<?= esc($a->message) ?>"
                                  >
                                      <i class="fas fa-edit"></i>
                                  </button>

                                  <!-- Delete Button with Confirmation -->
                                  <form class="deleteAnnouncementForm" action="<?= base_url('teacher/deleteAnnouncement/' . $a->id) ?>" method="post" style="display:inline;">
    <button type="submit" class="btn btn-sm btn-danger">
        <i class="fas fa-trash"></i>
    </button>
</form>
                              </td>

                          </tr>
                      <?php endforeach; ?>
                  <?php else: ?>
                      <tr>
                          <td colspan="5" class="text-center">No announcements found.</td>
                      </tr>
                  <?php endif; ?>
              </tbody>
          </table>

        </div>
      </main>
      <!-- Add Announcement Modal -->
      <div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-labelledby="addAnnouncementLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content shadow-sm">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="addAnnouncementLabel">New Announcement</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                aria-label="Close"></button>
            </div>
            <form id="announcementForm" method="post" action="<?= base_url('teacher-announcementPost') ?>">
              <div class="modal-body">
                <div class="mb-3">
                  <label for="announcementTitle" class="form-label">Title</label>
                  <input type="text" name='title' class="form-control" id="announcementTitle" required>
                </div>
                <div class="mb-3">
                  <label for="announcementMessage" class="form-label">Message</label>
                  <textarea class="form-control" name='message'  id="announcementMessage" rows="4" required></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Post</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Edit Announcement Modal -->
      <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form id="editAnnouncementForm" method="post" action="<?= base_url('teacher/updateAnnouncement') ?>">
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="edit-title" class="form-label">Title</label>
                  <input type="text" name="title" id="edit-title" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label for="edit-message" class="form-label">Message</label>
                  <textarea name="message" id="edit-message" class="form-control" rows="4" required></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </div>
          </form>
        </div>
      </div>



    </div>
  </div>

  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/admin.js"></script>
  <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // 1. Populate Edit Modal
    const editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const title = button.getAttribute('data-title');
            const message = button.getAttribute('data-message');

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-message').value = message;
        });
    }

    // 2. Add Announcement Confirmation
    const announcementForm = document.getElementById('announcementForm');
    if (announcementForm) {
        announcementForm.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to post this announcement?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, post it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    }

    // 3. Edit Announcement Confirmation
    const editForm = document.getElementById('editAnnouncementForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to update this announcement?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    }

    // 4. Delete Announcement Confirmation
    document.querySelectorAll('.deleteAnnouncementForm').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the announcement permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // 5. Optional: Show SweetAlert after flash messages (success/error)
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

