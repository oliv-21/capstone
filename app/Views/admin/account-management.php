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
   <style>
.is-invalid {
  border: 1px solid #dc3545 !important;
  background-color: #ffe6e6;
}
</style>

   <link rel="stylesheet" href="assets/css/admin.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
        
         <a href="<?= base_url(); ?>admin-accountManagement" class="nav-link d-flex align-items-center active">
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
        <h2 class="mb-4 text-primary">Account Management</h2>


                <!-- Teacher Account Creation Form -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-primary text-white">
            <i class="fa-solid fa-chalkboard-user me-2"></i> Create Teacher Account
          </div>
          <div class="card-body">
            <form id="teacherForm" method="post" action="<?= base_url('/admin-addTeacher') ?>" enctype="multipart/form-data">
              <?= csrf_field() ?>
              <div class="row g-3">

                <!-- Profile Picture -->
                <div class="col-md-3 text-center">
                  <img id="teacherPreview" src="<?= base_url('public/assets/profilepic/default.webp') ?>" 
                      alt="Teacher Picture" 
                      class="img-thumbnail mb-2"
                      style="width: 120px; height: 120px; object-fit: cover;">
                  <input type="file" name="teacher_picture" id="teacherPicture" 
                        class="form-control form-control-sm" accept="image/*"
                        onchange="previewTeacherImage(event)" >
                  <small class="text-muted">Upload 2x2 picture</small>
                </div>

                <!-- Account Info -->
                <div class="col-md-9">
                  <div class="row mb-2">
                    <div class="col-md-4">
                      <input type="text" name="first_name" class="form-control form-control-sm" placeholder="First Name" required>
                    </div>
                    <div class="col-md-4">
                      <input type="text" name="middle_name" class="form-control form-control-sm" placeholder="Middle Name">
                    </div>
                    <div class="col-md-4">
                      <input type="text" name="last_name" class="form-control form-control-sm" placeholder="Last Name" required>
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="col-md-6">
                      <input type="email" name="email" class="form-control form-control-sm" placeholder="Email" required>
                    </div>
                    <div class="col-md-6">
                      <input type="number" name="contact_number" class="form-control form-control-sm" placeholder="Contact Number" required>
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="col-md-6">
                      <input type="password" name="password" class="form-control form-control-sm" placeholder="Password" required>
                    </div>
                    <div class="col-md-6">
                      <input type="password" name="confirm_password" class="form-control form-control-sm" placeholder="Confirm Password" required>
                    </div>
                  </div>

                  <div class="row mb-2">
                    <div class="col-md-6">
                      <select class="form-select form-select-sm" name="teacher_department" required>
                         <?php foreach ($classes as $class): ?>
                                  <option value="<?= esc($class['classname']) ?>">
                                    <?= esc($class['classname']) ?>
                                  </option>
                          <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <input type="text" name="specialization" class="form-control form-control-sm" placeholder="Specialization (e.g. Math, English)">
                    </div>
                  </div>
                </div>
              </div>

              <div class="text-end mt-3">
                <button type="submit" class="btn btn-success" onclick="confirmAddTeacher()">
                  <i class="fa-solid fa-plus me-1"></i> Create Teacher
                </button>
              </div>
            </form>
          </div>
        </div>


        <div class="container-fluid d-flex align-items-center justify-content-between mb-3 flex-column flex-sm-row">
          <!-- Search Form -->
          <!-- <form id="customSearchForm" class="d-flex col-12 col-sm-4 me-3">
            <div class="input-group">
              <input type="text" id="customSearchBox" class="form-control rounded-start border-secondary" placeholder="Search">
              <button class="btn btn-secondary rounded-end" type="submit">Search</button>
            </div>
          </form> -->

          <!-- Class Dropdown -->
          <!-- <div class="d-flex align-items-center col-12 col-sm-3 flex-row mt-3 mt-sm-0">
            <label for="class" class="form-label fw-bold text-secondary me-2 mb-0 fs-5 ">Account Type</label>
            <select class="form-select rounded border-secondary" id="class">
              <option selected disabled>Select Account type</option>
              <option value="Student">Student</option>
            </select>

          </div> -->

        </div>
        <div class="container-fluid d-flex justify-content-between align-items-center flex-column col-12 flex-md-row">
          <div class="d-flex align-items-center col-8 col-sm-3">
            <label for="role" class="form-label fw-bold text-secondary me-2 mb-0 fs-5 bg">Role</label>
            <select class="form-select rounded border-secondary" id="filterRole" name="role">
              <option value="guardian">Guardian</option>
              <option value="teacher">Teacher</option>
              
            </select>
          </div>
        </div>


        



        <div class="table-responsive">
          <!-- Table -->
          <table class="table table-responsive table-hover align-middle" id="membersTable" class="table table-striped table-bordered">
            <thead class="primary-table-header">
              <tr>
                <th>Full Name (Last, First, M.I.)</th>
                <th>Role</th>
                <th>Email</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody id="admissionTable">
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= esc($user->Name); ?></td>
                  <td><?= esc($user->Role); ?></td>
                  <td><?= esc($user->Email); ?></td>
                  <td class="text-center">
                    <button class="btn btn-info btn-sm text-white px-4 details-btn"
                      data-role="<?= esc($user->Role) ?>"
                      data-userid="<?= esc($user->user_id) ?>"
                      data-admissionid="<?= esc($user->admission_id ?? '') ?>">
                      Details
                    </button>


                  </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
          </table>

          <!-- Modal -->
          <div class="modal fade" id="guardianDetailsModal">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-primary">
                  <h1 class="modal-title fs-5 text-white">
                    <i class="fa-solid fa-user-shield text-white me-2"></i> Guardian Information
                  </h1>
                  <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                  <!-- ✅ FORM STARTS HERE -->
                  <form method="post" action="<?= base_url('/admin-accountManagementpost') ?>" id="editGuardianForm" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Guardian Information -->
                    <h5 class="text-primary">
                      <i class="fa-solid fa-user me-2"></i> Guardian Information
                    </h5>
                    <div class="mb-3 ps-5">
                      <div class="row">
                        <!-- Thumbnail Preview -->
                        <div class="col-4">
                          <img id="modal-picture" src="" alt="Profile Picture" class="img-thumbnail me-3"
                            style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;">
                        </div>

                        <!-- Upload new picture -->
                        <div class="col-4">
                          <input type="file" 
                                name="profile_pic" 
                                id="profilepicInput" 
                                class="form-control form-control-sm" 
                                accept="image/*">
                          <small class="text-muted ms-1">Upload new profile picture</small>
                        </div>
                        <input type="hidden" name="existingPicture" id="existingPicture" value="">
                      </div>
                    </div>

                    <div class="mb-3 ps-5">
                      <div class="row mb-1">
                        <input type="hidden" name="user_id" value="">
                        <input type="hidden" name="id" value="">
                        <div class="col-4"><strong>First Name:</strong></div>
                        <div class="col-8"><input type="text" name='first_name' class="form-control form-control-sm" placeholder="First Name" value=""></div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-4"><strong>Middle Name:</strong></div>
                        <div class="col-8"><input type="text" name='middle_name' class="form-control form-control-sm" placeholder="Middle Name" value=""></div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-4"><strong>Last Name:</strong></div>
                        <div class="col-8"><input type="text" name='last_name' class="form-control form-control-sm" placeholder="Last Name" value=""></div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-4"><strong>Relationship:</strong></div>
                        <div class="col-8"><input type="text" name='relationship' class="form-control form-control-sm" placeholder="Relationship (e.g., Father, Mother, Aunt)" value=""></div>
                      </div>
                    </div>

                    <!-- Contact Information -->
                    <h5 class="text-primary">
                      <i class="fa-solid fa-address-book me-2"></i> Contact Information
                    </h5>
                    <div class="mb-3 ps-5">
                      <div class="row mb-1">
                        <div class="col-4"><strong>Contact Number:</strong></div>
                        <div class="col-8"><input type="text" name='contact_number' class="form-control form-control-sm" placeholder="Contact Number" value=""></div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-4"><strong>Email:</strong></div>
                        <div class="col-8"><input type="email" name='email' class="form-control form-control-sm" placeholder="Email" value=""></div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-4"><strong>Municipality:</strong></div>
                        <div class="col-8"><input type="text" name='municipality' class="form-control form-control-sm" placeholder="Municipality" value=""></div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-4"><strong>Barangay:</strong></div>
                        <div class="col-8"><input type="text" name='barangay' class="form-control form-control-sm" placeholder="Barangay" value=""></div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-4"><strong>Street:</strong></div>
                        <div class="col-8"><input type="text" name='street' class="form-control form-control-sm" placeholder="Street" value=""></div>
                      </div>
                    </div>
                  </form>  
                  <!-- ✅ FORM ENDS HERE -->

                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-success" onclick="saveChanges()">Save Changes</button>
                 
                </div>

                <!-- View Picture Modal -->
                <div class="modal fade" id="viewPictureModal-guardian" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body text-center">
                        <img id="large-picture-guardian" src="" alt="Guardian Picture" class="img-fluid rounded">
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>


          <div class="modal fade" id="teacherDetailsModal">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                  <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-primary">
                      <h1 class="modal-title fs-5 text-white">
                        <i class="fa-solid fa-file-lines text-white me-2"></i> Teacher Information
                      </h1>
                      <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">

                      <!-- Inside modal-body -->
                      <form method="post" action="<?= base_url('/admin-accountManagementTeacherpost') ?>" id="editTeacherForm" enctype="multipart/form-data">
                      <?= csrf_field() ?>
                        <!-- Student Information -->
                        <h5 class="text-primary">
                          <i class="fa-solid fa-user-graduate me-2"></i> Teacher Information
                        </h5>
                        <div class="mb-3 ps-5">
                          <div class="row">
                            <!-- Thumbnail Preview -->
                            <div class="col-4">
                                <img id="teacher-picture" src="" alt="2x2 Picture" class="img-thumbnail me-3"
                                style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;">
                            </div>
                            

                            <!-- Upload new picture123 -->
                            <div class="col-4">
                              <input type="file" 
                                    name="profilepicteacher" 
                                    id="profilepicTeacher" 
                                    class="form-control form-control-sm" 
                                    accept="image/*">
                              <small class="text-muted ms-1">Upload new 2x2 picture</small>
                            </div>
                            <input type="hidden" name="existingPictureTeacher" id="existingPictureTeacher" value="">
                              
                          </div>

                        </div>
                        <div class="mb-3 ps-5">
                          <div class="row mb-1">
                            <input type="hidden" name="user_id" value="">
                          
                            <div class="col-4"><strong>First Name:</strong></div>
                            <div class="col-8"><input type="text" name='first_name' class="form-control form-control-sm" placeholder="First Name" value=""></div>
                          </div>
                          <div class="row mb-1">
                            <div class="col-4"><strong>Middle Name:</strong></div>
                            <div class="col-8"><input type="text"  name='middle_name' class="form-control form-control-sm" placeholder="Middle Name" value=""></div>
                          </div>
                          <div class="row mb-1">
                            <div class="col-4"><strong>Last Name:</strong></div>
                            <div class="col-8"><input type="text"  name='last_name' class="form-control form-control-sm" placeholder="Last Name" value=""></div>
                          </div>
                          <div class="row mb-1">
                            <div class="col-4"><strong>Birthday</strong></div>
                            <div class="col-8"><input type="text"  name='birthday' class="form-control form-control-sm" placeholder="Birthday" value=""></div>
                          </div>
                           <div class="row mb-1">
                            <div class="col-4"><strong>Gender</strong></div>
                            <div class="col-8"><input type="text"  name='gender' class="form-control form-control-sm" placeholder="gender" value=""></div>
                          </div>
                           <div class="row mb-1">
                            <div class="col-4"><strong>Civil Status</strong></div>
                            <div class="col-8"><input type="text"  name='civil_status' class="form-control form-control-sm" placeholder="Civil Status" value=""></div>
                          </div>
                        </div>

                        <!-- Contact Information -->
                        <h5 class="text-primary">
                          <i class="fa-solid fa-address-book me-2"></i> Contact Information
                        </h5>
                        <div class="mb-3 ps-5">
                          <div class="row mb-1">
                            <div class="col-4"><strong>Contact Number:</strong></div>
                            <div class="col-8"><input type="text" name='contact_number' class="form-control form-control-sm" placeholder="Contact Number" value="">
                            </div>
                          </div>
                          <div class="row mb-1">
                            <div class="col-4"><strong>Email:</strong></div>
                            <div class="col-8"><input type="email" name='email' class="form-control form-control-sm"
                              placeholder="email" value=""></div>
                          </div>
                          <div class="row mb-1">
                            <div class="col-4"><strong>Municipality</strong></div>
                            <div class="col-8"><input type="text" name='municipality' class="form-control form-control-sm"
                              placeholder="Municipality" value=""></div>
                          </div>
                          <div class="row mb-1">
                            <div class="col-4"><strong>Barangay</strong></div>
                            <div class="col-8"><input type="text" name='barangay' class="form-control form-control-sm"
                              placeholder="Barangay" value=""></div>
                          </div>
                          <div class="row mb-1">
                            <div class="col-4"><strong>Street</strong></div>
                            <div class="col-8"><input type="text" name='street' class="form-control form-control-sm"
                              placeholder="Street" value=""></div>
                          </div>
                        </div>  
                        <!-- other Information -->
                        <h5 class="text-primary">
                          <i class="fa-solid fa-users me-2"></i> Other Information
                        </h5>
                        <div class="mb-3 ps-5">
                          <div class="row mb-1">
                            <div class="col-4"><strong>Specialization:</strong></div>
                            <div class="col-8"><input type="text" name='specialization'  class="form-control form-control-sm" placeholder="specialization" value="">
                            </div>
                          </div>
                        </div>
                        <div class="mb-3 ps-5">
                          <div class="row mb-1">
                            <div class="col-4"><strong>Teacher Department:</strong></div>
                            <div class="col-8"><input type="text" name='teacher_department'  class="form-control form-control-sm" placeholder="teacher_department" value="">
                            </div>
                          </div>
                        </div>               
                      </form>   
                    
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-success" onclick="saveChangesTeacher()">Save Changes</button>
                      <a href="#"
                      id="generateIdLink"
                        class="btn btn-outline-secondary"
                        target="_blank">
                        Generate ID
                      </a>
                    </div>
                    <!-- View Picture Modal (outside student modal) -->
                    <div class="modal fade" id="viewPictureModal-teacher" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body text-center">
                            <img id="large-picture-teacher" src="" alt="teacher Picture" class="img-fluid rounded">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
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
   <!-- sweetalert link -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function () {
    // 🔎 Init DataTable
    var table = $('#membersTable').DataTable({
      
      
    });

    // 🔎 Custom search box
    $('#customSearchBox').on('keyup', function () {
      table.search(this.value).draw();
    });

    // 🎯 Filter by Role dropdown
    $('#filterRole').on('change', function () {
      var selected = $(this).val();
      console.log("Selected role:", selected);
      table.column(1).search(selected).draw();
    });
     var selectedClass = $('#filterRole').val();
    if(selectedClass){
      table.column(1).search(selectedClass).draw();
    }

    // 🎯 Handle "Details" button clicks
    $(document).on("click", ".details-btn", function () {
      var role = $(this).data("role");
      var userId = $(this).data("userid");
      console.log("User ID:", userId, "Role:", role);

      if (role.toLowerCase() === "guardian") {
        $.get("<?= base_url('admin/getGuardianDetails') ?>/" + userId, function (data) {
          if (data.length > 0) {
            fillGuardianModal(data[0]);
            console.log(data[0]);
          }
          $("#guardianDetailsModal").modal("show");
        }, "json");
      } else {
        $.get("<?= base_url('admin/getTeacherDetails') ?>/" + userId, function (data) {
          if (data.length > 0) {
            fillTeacherModal(data[0]);
            console.log(data[0]);
          }
          $("#teacherDetailsModal").modal("show");
        }, "json");
      }
    });

    // 🖼️ Open large picture modal when clicking the small picture
    $(document).on("click", "#modal-picture", function () {
      const viewModal = new bootstrap.Modal(document.getElementById('viewPictureModal-guardian'));
      viewModal.show();
      $('#large-picture-guardian').attr('src', $(this).attr('src'));
    });
     $(document).on("click", "#teacher-picture", function () {
      const viewModal = new bootstrap.Modal(document.getElementById('viewPictureModal-teacher'));
      viewModal.show();
      $('#large-picture-teacher').attr('src', $(this).attr('src'));
    });
  });

  // ✅ Guardian modal filler
  function fillGuardianModal(guardian) {
    const modal = document.getElementById('guardianDetailsModal');

    modal.querySelector('input[name="user_id"]').value = guardian.user_id || '';
    modal.querySelector('input[name="id"]').value = guardian.id || '';
    modal.querySelector('input[placeholder="First Name"]').value = guardian.first_name || '';
    modal.querySelector('input[placeholder="Middle Name"]').value = guardian.middle_name || '';
    modal.querySelector('input[placeholder="Last Name"]').value = guardian.last_name || '';
    modal.querySelector('input[placeholder="Relationship (e.g., Father, Mother, Aunt)"]').value = guardian.relationship || '';
    modal.querySelector('input[placeholder="Contact Number"]').value = guardian.contact_number || '';
    modal.querySelector('input[type="email"]').value = guardian.email || '';
    modal.querySelector('input[placeholder="Municipality"]').value = guardian.municipality || '';
    modal.querySelector('input[placeholder="Barangay"]').value = guardian.barangay || '';
    modal.querySelector('input[placeholder="Street"]').value = guardian.street || '';

    // 🖼️ Profile picture
    const picturePath = guardian.profile_pic
      ? "<?= base_url('public/assets/profilepic/') ?>" + guardian.profile_pic
      : "<?= base_url('public/assets/profilepic/default.webp') ?>";
    document.getElementById('modal-picture').setAttribute('src', picturePath);
    document.getElementById('existingPicture').value = guardian.profile_pic || '';

    // 🔗 Optional: Generate ID link (if applicable)
    const generateIdLink = modal.querySelector('#generateIdLink');
    if (generateIdLink && guardian.id) {
      generateIdLink.href = "<?= base_url('admin/generateId/') ?>" + guardian.id;
    }
  }
//123
  // ✅ Teacher modal filler (unchanged)
  function fillTeacherModal(teacher) {
  const modal = document.getElementById('teacherDetailsModal');

  modal.querySelector('input[name="user_id"]').value = teacher.user_id || '';
  modal.querySelector('input[name="first_name"]').value = teacher.first_name || '';
  modal.querySelector('input[name="middle_name"]').value = teacher.middle_name || '';
  modal.querySelector('input[name="last_name"]').value = teacher.last_name || '';
  modal.querySelector('input[name="birthday"]').value = teacher.birthday || '';
  modal.querySelector('input[name="gender"]').value = teacher.gender || '';
  modal.querySelector('input[name="civil_status"]').value = teacher.civil_status || '';
  modal.querySelector('input[name="contact_number"]').value = teacher.contact_number || '';
  modal.querySelector('input[name="email"]').value = teacher.email || '';
  modal.querySelector('input[name="municipality"]').value = teacher.municipality || '';
  modal.querySelector('input[name="barangay"]').value = teacher.barangay || '';
  modal.querySelector('input[name="street"]').value = teacher.street || '';
  modal.querySelector('input[name="specialization"]').value = teacher.specialization || '';
  modal.querySelector('input[name="teacher_department"]').value = teacher.teacher_department || '';

  document.getElementById('existingPictureTeacher').value = teacher.profile_pic || '';

  const picturePath = teacher.profile_pic
    ? "<?= base_url('public/assets/profilepic/') ?>" + teacher.profile_pic
    : "<?= base_url('public/assets/profilepic/default.webp') ?>";
  document.getElementById('teacher-picture').setAttribute('src', picturePath);
}


  // ✅ Teacher image preview on upload
  function previewTeacherImage(event) {
    const output = document.getElementById('teacherPreview');
    output.src = URL.createObjectURL(event.target.files[0]);
  }
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Confirmation Example (for a delete button or form submit)
    const deleteBtn = document.getElementById("deleteBtn"); // your button id
    if(deleteBtn){
        deleteBtn.addEventListener("click", function(e){
            e.preventDefault(); // prevent immediate action

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ✅ Proceed with action (submit form or redirect)
                    document.getElementById("deleteForm").submit();
                }
            });
        });
    }

    // Flash messages (after redirect)
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
function confirmAddTeacher(e) {
  e.preventDefault();
  const form = document.getElementById('teacherForm');
  const inputs = form.querySelectorAll('input, select');
  
  // Remove previous highlights
  inputs.forEach(el => el.classList.remove('is-invalid'));

  const firstName = form.querySelector('input[name="first_name"]');
  const lastName = form.querySelector('input[name="last_name"]');
  const email = form.querySelector('input[name="email"]');
  const contact = form.querySelector('input[name="contact_number"]');
  const password = form.querySelector('input[name="password"]');
  const confirmPassword = form.querySelector('input[name="confirm_password"]');
  const department = form.querySelector('select[name="teacher_department"]');

  let isValid = true;
  let message = '';

  // Empty fields check
  [firstName, lastName, email, contact, password, confirmPassword, department].forEach(field => {
    if (!field.value.trim()) {
      field.classList.add('is-invalid');
      isValid = false;
    }
  });

  if (!isValid) {
    Swal.fire({
      icon: 'warning',
      title: 'Missing Fields',
      text: 'Please fill in all required fields.',
      confirmButtonColor: '#3085d6'
    });
    return;
  }

  // Email format check
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email.value.trim())) {
    email.classList.add('is-invalid');
    Swal.fire({
      icon: 'error',
      title: 'Invalid Email',
      text: 'Please enter a valid email address.'
    });
    return;
  }

  // Contact number check (11 digits)
  if (!/^[0-9]{11}$/.test(contact.value.trim())) {
    contact.classList.add('is-invalid');
    Swal.fire({
      icon: 'error',
      title: 'Invalid Contact Number',
      text: 'Contact number must be 11 digits.'
    });
    return;
  }

  // Password length
  if (password.value.length < 6) {
    password.classList.add('is-invalid');
    Swal.fire({
      icon: 'error',
      title: 'Weak Password',
      text: 'Password must be at least 6 characters.'
    });
    return;
  }

  // Password match
  if (password.value !== confirmPassword.value) {
    password.classList.add('is-invalid');
    confirmPassword.classList.add('is-invalid');
    Swal.fire({
      icon: 'error',
      title: 'Password Mismatch',
      text: 'Passwords do not match.'
    });
    return;
  }

  // ✅ Confirmation before submit
  Swal.fire({
    title: 'Add teacher?',
    text: 'Are you sure you want to save these teacher details?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, Save',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#3085d6'
  }).then((result) => {
    if (result.isConfirmed) {
      form.submit();
    }
  });
}
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