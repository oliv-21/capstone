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
  <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css'); ?>">

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/admin.css'); ?>">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img  id="schoolLogo"  src="<?= base_url('assets/img/logoicon.png'); ?>" alt="Logo" class="me-3 ms-1" style="width: 38px;">
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
         
         <?php if(session()->get('admin_role') === 'Admin'): ?>
        <a href="<?= base_url(); ?>admin/getAdminDetails" class="nav-link d-flex align-items-center">
            <i class="fas fa-clipboard-list me-4 fa-lg fa-fw text-secondary"></i> Audit Log
        </a>

         <?php endif; ?>
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
        <main class="px-4 py-4 bg-light" style="height: calc(100vh - 56px); overflow-y: auto;">

    <!-- ADMIN ACCOUNTS TABLE -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Admin Accounts</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            
                            
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="adminAccountsTable">
                        <?php foreach($adminAccounts as $i => $admin): ?>
                            <tr>
                                <td><?= $i+1 ?></td>
                                <td><?= $admin['full_name'] ?></td>
                                <td><?= $admin['status'] ?></td>
                                <td>
                                    <!-- Edit Button -->
                                   <button type="button" class="btn btn-sm btn-primary me-1" onclick="openEditModal('<?= $admin['user_id'] ?>')">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>


                                    <!-- Delete Button -->
                                    
                                </td>
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- AUDIT LOG TABLE -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Audit Log Records</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                            <th>Description</th>
                            
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody id="auditLogTable">
                        
                        <?php $total = count($auditLogs); ?>
                        <?php foreach($auditLogs as $j => $log): ?>
                            <tr>
                                <td><?= $total - $j ?></td>
                                <td><?= esc($log['done_by']) ?></td>
                                <td><?= esc($log['action']) ?></td>
                                <td><?= esc($log['description']) ?></td>
                                
                                <td><?= date('F j, Y', strtotime($log['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- Edit Admin Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editAdminForm">
        <div class="modal-header">
          <h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editAdminId" name="user_id">
          <div class="mb-3">
            <label for="editFullName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="editfirstname" name="firstname" required>
          </div>
          <div class="mb-3">
            <label for="editFullName" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="editmiddlename" name="middlename" required>
          </div>
          <div class="mb-3">
            <label for="editFullName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="editlastname" name="lastname" required>
          </div>
          <div class="mb-3">
            <label for="editStatus" class="form-label">Status</label>
            <select class="form-select" id="editStatus" name="status" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
          <!-- Add more fields if needed -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
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
  <script src="<?= base_url('dist/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/admin.js'); ?>"></script>
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
    
    
    function markAsRead(userId) {
      fetch("<?= base_url('notifications/markAsRead/') ?>" + userId)
        .then(response => {
          if (response.ok) {
            const badge = document.getElementById('notifBadge');
            if (badge) badge.style.display = 'none';
          }
        });
    }
   function openEditModal(userId) {
    if(!userId) {
        console.error("No userId provided!");
        return;
    }

    fetch("<?= base_url('admin/getAdminDetails') ?>/" + userId)
    .then(res => res.json())
    .then(data => {
        console.log(data); // check what you receive
        document.getElementById('editAdminId').value = data.user_id;
        document.getElementById('editfirstname').value = data.firstname;
        document.getElementById('editmiddlename').value = data.middlename;
        document.getElementById('editlastname').value = data.lastname;
        document.getElementById('editStatus').value = data.status;

        const modal = new bootstrap.Modal(document.getElementById('editAdminModal'));
        modal.show();
    })
    .catch(err => console.error('Fetch error:', err));
}


// Handle form submission
document.getElementById('editAdminForm').addEventListener('submit', function(e){
  e.preventDefault();
  const formData = new FormData(this);
  const userId = document.getElementById('editAdminId').value; // get the ID dynamically

  fetch("<?= base_url('admin/updateAdminAccount') ?>/" + userId, {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if(data.success){
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Admin updated successfully!',
        confirmButtonText: 'OK'
      }).then(() => {
        location.reload(); // Reload table or page
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: data.message || 'Failed to update admin',
      });
    }
  })
  .catch(err => {
    console.error(err);
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Something went wrong!',
    });
  });
});



  </script>


</body>

</html>