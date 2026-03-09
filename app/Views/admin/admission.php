<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Admin Admission</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />


<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css'); ?>">
<link href="assets/img/logoicon.png" rel="icon" />

<!-- Custom Admin CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/admin.css'); ?>">



  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <style>
  @media print {
    body * {
      visibility: hidden;
    }

    #print-section, #print-section * {
      visibility: visible;
    }

    #print-section {
      position: absolute;
      left: 0;
      top: 0;
    }
  }
   .hidden-on-screen {
    visibility: hidden;
     display: none;
  }

  /* Pag nagpi-print, ipakita ulit */
  @media print {
    .hidden-on-screen {
      visibility: visible;
        display: block;
    }
  }
  
</style>

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
         
        <a href="<?= base_url(); ?>admin-admission" class="nav-link d-flex align-items-center position-relative active">
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

        <div class="row align-items-center mb-4">
          <div class="col-md-8">
            <h2 class="text-primary">Admission</h2>
          </div>

          <div class="col-md-4 text-md-end">
            <button class="btn btn-success me-2" onclick="window.location.href='<?= base_url(); ?>admin-openAdmission'"><i class="fa-solid fa-plus me-1"></i> Open Admission</button>
            <button class="btn btn-primary px-4" onclick="window.location.href='<?= base_url(); ?>admin-archived'">
              <i class="fa-solid fa-box-archive me-2"></i>Archive
            </button>
          </div>
        </div>
        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4 border-0" id="admissionTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active fw-semibold text-dark" id="pending-tab"
              data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab"
              aria-controls="pending" aria-selected="true">
                <i class="fa-solid fa-user-plus me-2"></i>Admission Requests
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold text-dark" id="approved-tab"
              data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab"
              aria-controls="approved" aria-selected="false">
                <i class="fa-solid fa-comments me-2"></i>For Interview
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold text-dark" id="enrollee-tab"
              data-bs-toggle="tab" data-bs-target="#enrollee" type="button" role="tab"
              aria-controls="enrollee" aria-selected="false">
              <i class="fa-solid fa-credit-card me-2"></i>Enrollment Payment
            </button>
          </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="admissionTabsContent">

          <!-- Pending Tab -->
          <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
            <div class="table-responsive shadow-sm border">
              <table class="table table-hover align-middle mb-0">
                <thead class="primary-table-header">
                  <tr>
                    <th>ID</th>
                    <th>Full Name (Last, First, M.I.)</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody id="admissionTable">
                  <?php foreach ($members as $member): ?>
                    <?php if (strtolower($member->status) === 'pending'): ?>
                      <tr>
                        <td><?= esc($member->admission_id) ?></td>
                        <td><?= esc($member->full_name) ?></td>
                      <td><?= date('F j, Y', strtotime($member->submitted_at)) ?></td>

                        <td class="text-center d-flex justify-content-center gap-2">
                          <button
                            class="btn btn-info btn-sm text-white px-4"
                            data-bs-toggle="modal"
                            data-bs-target="#mymodal"
                            data-fullname="<?= esc($member->full_name) ?>"
                            data-firstname="<?= esc($member->first_name) ?>"
                            data-middlename="<?= esc($member->middle_name) ?>"
                            data-lastname="<?= esc($member->last_name) ?>"
                            data-nickname="<?= esc($member->nickname) ?>"
                            data-nationality="<?= esc($member->nationality) ?>"
                            data-gender="<?= esc($member->gender) ?>"
                            data-birthday="<?= esc($member->birthday) ?>"
                            data-age="<?= esc($member->age) ?>"
                            data-classroom="<?= esc($member->class_applied) ?>"
                            data-fathername="<?= esc($member->father_name) ?>"
                            data-fatherocc="<?= esc($member->father_occupation) ?>"
                            data-mothername="<?= esc($member->mother_name) ?>"
                            data-motherocc="<?= esc($member->mother_occupation) ?>"
                            data-address ="<?= esc($member->address) ?>"
                            data-contact="<?= esc($member->contact_number) ?>"
                            data-email="<?= esc($member->email) ?>"
                            data-status="<?= esc($member->status) ?>"
                            data-picture="<?= esc($member->picture) ?>"
                            data-admission_id ="<?= esc($member->admission_id ) ?>"
                            data-submitted_at ="<?= esc($member->submitted_at ) ?>"
                            data-userID ="<?= esc($member->user_id) ?>"
                            data-PSA ="<?= esc($member->psa) ?>"
                            
                          >
                            <i class="fa-solid fa-eye me-2"></i>View
                          </button>  
                        </td>
                      </tr>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- interview Tab -->
          <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
            <div class="table-responsive shadow-sm border">
              <table class="table table-hover align-middle mb-0">
                <thead class="primary-table-header">
                  <tr>
                    <th>ID</th>
                    <th>Full Name (Last, First, M.I.)</th>
                    <th>Details</th>
                    <!-- <th>Approve by</th> -->
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($members as $member): ?>
                    <?php if (strtolower($member->status) === 'approved'): ?>
                    <tr>
                      <td><?= esc($member->admission_id) ?></td>
                      <td><?= esc($member->full_name) ?></td>
                      <td >
                        <button
                            class="btn btn-info btn-sm text-white px-4"
                            data-bs-toggle="modal"
                            data-bs-target="#mymodal"
                            data-fullname="<?= esc($member->full_name) ?>"
                            data-firstname="<?= esc($member->first_name) ?>"
                            data-middlename="<?= esc($member->middle_name) ?>"
                            data-lastname="<?= esc($member->last_name) ?>"
                            data-nickname="<?= esc($member->nickname) ?>"
                            data-nationality="<?= esc($member->nationality) ?>"
                            data-gender="<?= esc($member->gender) ?>"
                            data-birthday="<?= esc($member->birthday) ?>"
                            data-age="<?= esc($member->age) ?>"
                            data-classroom="<?= esc($member->class_applied) ?>"
                            data-fathername="<?= esc($member->father_name) ?>"
                            data-fatherocc="<?= esc($member->father_occupation) ?>"
                            data-mothername="<?= esc($member->mother_name) ?>"
                            data-motherocc="<?= esc($member->mother_occupation) ?>"
                            data-address ="<?= esc($member->address) ?>"
                            data-contact="<?= esc($member->contact_number) ?>"
                            data-email="<?= esc($member->email) ?>"
                            data-status="<?= esc($member->status) ?>"
                            data-picture="<?= esc($member->picture) ?>"
                            data-admission_id ="<?= esc($member->admission_id ) ?>"
                            data-submitted_at ="<?= esc($member->submitted_at ) ?>"
                            data-userID ="<?= esc($member->user_id) ?>"
                            data-PSA ="<?= esc($member->psa) ?>"
                            ><i class="fa-solid fa-eye me-2"></i>View
                        </button>
                      </td>
                      <!-- <td><?= esc($member->approve_by) ?></td> -->
                      <td class="text-center">
                        <?php $isApproved = strtolower($member->status) === 'approved'; ?>
                          <div class="d-inline-flex">
                            <button 
                              class="btn btn-danger btn-sm text-white me-2 px-3 <?= $isApproved ? '' : 'disabled' ?>" 
                              <?= $isApproved ? '' : 'disabled' ?>
                              onclick="rejectStudent('<?= esc($member->admission_id) ?>', '<?= esc($member->email) ?>')">
                              <i class="fa-solid fa-xmark me-2"></i>Reject
                            </button>

                            <button 
                              class="btn btn-success btn-sm text-white px-4 <?= $isApproved ? '' : 'disabled' ?>" 
                              <?= $isApproved ? '' : 'disabled' ?>
                              onclick="updateStatus('<?= esc($member->admission_id) ?>', 'Pre-enrollee', '', '<?= esc($member->email) ?>')">
                              <i class="fa-solid fa-check me-2"></i>Passed
                            </button>

                            

                          </div>
                      </td>
                    </tr>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Interview Failed Tab -->
          <div class="tab-pane fade" id="enrollee" role="tabpanel" aria-labelledby="enrollee-tab">
            <div class="table-responsive shadow-sm ">
              <table class="table table-hover align-middle mb-0">
                <thead class="primary-table-header">
                  <tr>
                    <th>ID</th>
                    <th>Full Name (Last, First, M.I.)</th>
                    
                    <th>Details</th>
                    <!-- <th>Approve by</th> -->
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($members as $member): ?>
                    <?php if (strtolower($member->status) === 'pre-enrollee'): ?>
                    <tr>
                      <td><?= esc($member->admission_id) ?></td>
                      <td><?= esc($member->full_name) ?></td>
                       
                      <td>
                        <button
                            class="btn btn-info btn-sm text-white px-4"
                            data-bs-toggle="modal"
                            data-bs-target="#mymodal"
                            data-fullname="<?= esc($member->full_name) ?>"
                            data-firstname="<?= esc($member->first_name) ?>"
                            data-middlename="<?= esc($member->middle_name) ?>"
                            data-lastname="<?= esc($member->last_name) ?>"
                            data-nickname="<?= esc($member->nickname) ?>"
                            data-nationality="<?= esc($member->nationality) ?>"
                            data-gender="<?= esc($member->gender) ?>"
                            data-birthday="<?= esc($member->birthday) ?>"
                            data-age="<?= esc($member->age) ?>"
                            data-classroom="<?= esc($member->class_applied) ?>"
                            data-fathername="<?= esc($member->father_name) ?>"
                            data-fatherocc="<?= esc($member->father_occupation) ?>"
                            data-mothername="<?= esc($member->mother_name) ?>"
                            data-motherocc="<?= esc($member->mother_occupation) ?>"
                            data-address ="<?= esc($member->address) ?>"
                            data-contact="<?= esc($member->contact_number) ?>"
                            data-email="<?= esc($member->email) ?>"
                            data-status="<?= esc($member->status) ?>"
                            data-picture="<?= esc($member->picture) ?>"
                            data-admission_id ="<?= esc($member->admission_id ) ?>"
                            data-submitted_at ="<?= esc($member->submitted_at ) ?>"
                            data-userID ="<?= esc($member->user_id) ?>"
                            data-PSA ="<?= esc($member->psa) ?>"
                            ><i class="fa-solid fa-eye me-2"></i>View
                        </button>
                      </td>
                      <!-- <td><?= esc($member->approve_by) ?></td> -->
                      <td class="text-center">
                        <a href="<?= base_url('/student-paycash/' . esc($member->admission_id)); ?>"  
                          class="btn btn-success btn-sm text-white px-4 ms-4">
                          <i class="fa-solid fa-money-bill-wave me-2"></i>Pay Cash
                        </a>
                      </td>
                      
                      
                    </tr>

                    <?php endif; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        




      

        <!-- Modal -->
        <div class="modal fade" id="mymodal">
          <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header bg-primary">
                <h1 class="modal-title fs-5 text-white">
                  <i class="fa-solid fa-file-lines text-white me-2"></i> Applicant Information
                </h1>
                <button class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <!-- Modal Body -->
              <div class="modal-body">
                <!-- Student Information -->
                <div class="d-flex justify-content-between align-items-center">
                  <h5 class="text-primary mb-0">
                    <i class="fa-solid fa-user-graduate me-2"></i> Student Information
                  </h5>
                  <a id="printLink" class="btn btn-outline-secondary btn-sm " href="#" target="_blank">Print</a>
                </div>
                
                <div class="d-flex align-items-center mb-3 ms-5">
                  <img id="modal-picture" src="" alt="2x2 Picture" class="img-thumbnail me-3"
                  style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;">
                </div>
                  
                <div class="mb-3 ps-5">
                  <div id="modal-fullname" hidden></div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>First Name:</strong></div>
                    <div class="col-8" id="modal-firstname"></div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>Middle Name:</strong></div>
                    <div class="col-8" id="modal-middlename"></div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>Last Name:</strong></div>
                    <div class="col-8" id="modal-lastname"></div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>Nickname:</strong></div>
                    <div class="col-8" id="modal-nickname"></div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>Nationality:</strong></div>
                    <div class="col-8" id="modal-nationality"></div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>Gender:</strong></div>
                    <div class="col-8" id="modal-gender"></div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>Birthday:</strong></div>
                    <div class="col-8" id="modal-birthday"></div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>Age:</strong></div>
                    <div class="col-8" id="modal-age"></div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>Address:</strong></div>
                    <div class="col-8" id="modal-address"></div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>Class:</strong></div>
                    <div class="col-8" id="modal-classroom"></div>
                  </div>
                </div>

                <!-- Parent Information -->
                <h5 class="text-primary">
                  <i class="fa-solid fa-users me-2"></i> Parent Information
                </h5>
                <div class="mb-3 ps-5">
                  <div class="row mb-1">
                    <div class="col-4"><strong>Father's Name:</strong></div>
                    <div class="col-8" id="modal-fathername"></div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>Father's Occupation:</strong></div>
                    <div class="col-8" id="modal-fatherocc"></div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>Mother's Name:</strong></div>
                    <div class="col-8" id="modal-mothername"></div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>Mother's Occupation:</strong></div>
                    <div class="col-8" id="modal-motherocc"></div>
                  </div>
                </div>

                <!-- Contact Information -->
                <h5 class="text-primary">
                  <i class="fa-solid fa-address-book me-2"></i> Contact Information
                </h5>
                <div class="mb-3 ps-5">
                  <div class="row mb-1">
                    <div class="col-4"><strong>Contact Number:</strong></div>
                    <div class="col-8" id="modal-contact"></div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-4"><strong>Email:</strong></div>
                    <div class="col-8" id="modal-email"></div>
                  </div>
                </div>
                <h5 class="text-primary">
                  <i class="fa-solid fa-address-book me-2"></i> Documents
                </h5>
                <div class="mb-3 ps-5">
                  <div class="row mb-1">
                    <div class="col-4"><strong>PSA</strong></div>
                    <div class="col-8" >
                      <img src="" id="modal-psa" alt="PSA Document" class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                      <br>
                      <a id="psa-download" href="#" class="btn btn-outline-primary btn-sm mt-2" download>
                        <i class="fa-solid fa-download me-1"></i> Download PSA
                      </a>

                    </div>
                  </div>
                </div>
                
                  

              </div>
              <!-- View Picture Modal (outside student modal) -->
              <div class="modal fade" id="viewPictureModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                      <img id="large-picture" src="" alt="Student Picture" class="img-fluid rounded">
                    </div>
                  </div>
                </div>
              </div>


              
              <form id="statusForm" action="<?= base_url('admin-admissionpost') ?>" method="post" class="modal-content">
                    
                <input type="hidden" name="admission_id" id="modalAdmissionId" value="" />
                <input type="hidden" name="status" id="modalStatus" value="" />
                <input type="hidden" name="userID" id="modalUserID" value="" />
                <input type="hidden" name="reason" id="disapproveReason">

                
              </form>
              <div class="modal-footer" id="modal-footer">
                <button type="button" class="btn btn-outline-danger " onclick="confirmStatus('Disapproved')">
                  <i class="fa-solid fa-xmark me-2"></i>Disapprove
                </button>
                <button type="button" class="btn btn-success px-4" onclick="confirmStatus('Approved')">
                  <i class="fa-solid fa-check me-2"></i>Approve
                </button>
              </div>
            </div>
          </div>
          
        </div>
      </main>
    </div>
  </div>


  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>


  <script>

    // Function to set the status and submit the form
    function confirmStatus(status) {
        const isApproved = status === 'Approved';

        if (isApproved) {
          Swal.fire({
            title: `${status} Admission?`,
            text: `Are you sure you want to approve this student's admission?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Approve'
          }).then((result) => {
            if (result.isConfirmed) {
              $('#modalStatus').val(status);
              $('#statusForm').submit();
            }
          });
          return;
        }

        // Hide bootstrap modal so SweetAlert can receive focus
        $('#mymodal').modal('hide');

        Swal.fire({
          title: 'Disapprove Admission',
          input: 'textarea',
          inputLabel: 'Reason for disapproval',
          inputPlaceholder: 'Type your reason here...',
          showCancelButton: true,
          confirmButtonText: 'Submit',
          preConfirm: (reason) => {
            if (!reason || !reason.trim()) {
              Swal.showValidationMessage('Reason is required');
            }
            console.log(reason)
            return reason;
          },
          didOpen: () => {
            Swal.getInput().focus();
          }
        }).then((result) => {
          if (result.isConfirmed) {
            $('#modalStatus').val(status);
            $('#disapproveReason').val(result.value);
            $('#statusForm').submit();
          } else {
            // If cancelled, reopen the modal (optional)
            $('#mymodal').modal('show');
          }
        });
      }



      function confirmEnrollment(form) {
        event.preventDefault(); // stop direct submit

        Swal.fire({
          title: 'Mark as Enrolled?',
          text: "Are you sure you want to mark this student as enrolled?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes, Enroll',
          cancelButtonText: 'Cancel',
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#6c757d'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
            location.reload();
             // submit the form only if confirmed
          }
        });

        return false; // always stop default form submit until confirmed
      }
      


    // Event listener for when the modal is about to be shown
    var myModal = document.getElementById('mymodal');
    myModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget; 


       
       var fullname = button.getAttribute('data-fullname') || '';
          document.getElementById('modal-fullname').textContent = fullname;
       var firstname = button.getAttribute('data-firstname') || '';
          document.getElementById('modal-firstname').textContent = firstname;
        var middlename = button.getAttribute('data-middlename') || '';
          document.getElementById('modal-middlename').textContent = middlename;
        var lastname = button.getAttribute('data-lastname') || '';
          document.getElementById('modal-lastname').textContent = lastname;
        var nickname = button.getAttribute('data-nickname') || '';
          document.getElementById('modal-nickname').textContent = nickname;
        var nationality = button.getAttribute('data-nationality') || '';
          document.getElementById('modal-nationality').textContent = nationality;
        var gender = button.getAttribute('data-gender') || '';
          document.getElementById('modal-gender').textContent = gender;
        var birthday = button.getAttribute('data-birthday') || '';
          document.getElementById('modal-birthday').textContent = birthday;
        var age = button.getAttribute('data-age') || '';
          document.getElementById('modal-age').textContent = age;
        var classroom = button.getAttribute('data-classroom') || '';
          document.getElementById('modal-classroom').textContent = classroom;
        var fathername = button.getAttribute('data-fathername') || '';
          document.getElementById('modal-fathername').textContent = fathername;
        var fatherocc = button.getAttribute('data-fatherocc') || '';
          document.getElementById('modal-fatherocc').textContent = fatherocc;
        var mothername = button.getAttribute('data-mothername') || '';
          document.getElementById('modal-mothername').textContent = mothername;
        var motherocc = button.getAttribute('data-motherocc') || '';
          document.getElementById('modal-motherocc').textContent = motherocc;
        var address = button.getAttribute('data-address') || '';
          document.getElementById('modal-address').textContent = address;
        var contact = button.getAttribute('data-contact') || '';
          document.getElementById('modal-contact').textContent = contact;
        var email = button.getAttribute('data-email') || '';
          document.getElementById('modal-email').textContent = email;
        

          var status = button.getAttribute('data-status') || '';
          var footer = document.getElementById('modal-footer');
        console.log(status)
          // Show only if status is 'Pending'
          if (status.toLowerCase() === 'pending') {
            footer.style.display = 'flex';
          } else {
            footer.style.display = 'none';
          }

        

      



        var picture = button.getAttribute('data-picture') || '';
        var picturePath = picture ? "<?= base_url('public/assets/profilepic/') ?>" + picture : "<?= base_url('public/assets/profilepic/default.webp') ?>";
          document.getElementById('modal-picture').setAttribute('src', picturePath);
        var psa = button.getAttribute('data-PSA') || '';
        var psaPath = psa ? "<?= base_url('public/assets/psa/') ?>" + psa : "<?= base_url('public/assets/profilepic/default.webp') ?>";
          document.getElementById('modal-psa').setAttribute('src', psaPath);

        
      // Set the hidden admission_id input value in the form
      document.getElementById('modalAdmissionId').value = button.getAttribute('data-admission_id') || '';
       document.getElementById('modalUserID').value = button.getAttribute('data-userID') || '';
      // ✅ Update the print link dynamically
      let admissionId = button.getAttribute('data-admission_id');
      document.getElementById('printLink').href = "<?= site_url('admin/print-student/') ?>" + admissionId;
            document.getElementById('psa-download').setAttribute('href', psaPath);
      

    });
    
    


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

</script>
<script>
  document.getElementById('modal-picture').addEventListener('click', function () {
    // Get the image source from the small picture
    var imgSrc = this.getAttribute('src');

    // Set that source to the image in the modal
    document.getElementById('large-picture').setAttribute('src', imgSrc);

    // Show the modal
    var viewModal = new bootstrap.Modal(document.getElementById('viewPictureModal'));
    viewModal.show();
  });
</script>





<!-- JS Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="assets/js/admin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function () {
    $('#membersTable').DataTable();
  });

  function setActiveTab(tabId) {
    document.querySelectorAll('#admissionTabs .nav-link').forEach(tab => {
      tab.classList.remove('active');
      tab.setAttribute('aria-selected', 'false');
    });
    const targetTab = document.getElementById(tabId);
    if (targetTab) {
      targetTab.classList.add('active');
      targetTab.setAttribute('aria-selected', 'true');
      const targetPaneId = targetTab.getAttribute('data-bs-target');
      document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.classList.remove('show', 'active');
      });
      document.querySelector(targetPaneId).classList.add('show', 'active');
    }
  }

  function removeTableRow(admissionId) {
    const row = document.querySelector(`[data-id='${admissionId}']`);
    if (row) row.remove();
  }

  function updateStatus(admissionId, status, reason = '', email = '', first_name = '', last_name = '') {
    Swal.fire({
      title: `Confirm ${status}`,
      text: `Are you sure you want to mark this student as "${status}"?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, proceed',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch("<?= site_url('admin/updateStatusInterview') ?>", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ 
            admission_id: admissionId, 
            status: status, 
            reason: reason,
            email: email,
            first_name: first_name,
            last_name: last_name
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
        icon: 'success',
        title: 'Success',
        text: data.message,
        timer: 1500,
        showConfirmButton: false
    }).then(() => {
        location.reload();  // 🔥 reload after Swal auto-closes
    });

            removeTableRow(admissionId);

            if (status === 'Approved') setActiveTab('approved-tab');
            else if (status === 'Pre-enrollee') setActiveTab('enrollee-tab');
            else if (status === 'Interview Failed') setActiveTab('pending-tab');
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message,
            });
          }
        })
        .catch(err => {
          console.error(err);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong while updating the status.',
          });
        });
      }
    });
  }

  function rejectStudent(admissionId, email, first_name, last_name) {
    Swal.fire({
      title: 'Reject Student',
      text: 'Please enter reason for rejection:',
      input: 'text',
      inputPlaceholder: 'Enter reason here...',
      showCancelButton: true,
      confirmButtonText: 'Reject',
      cancelButtonText: 'Cancel',
      inputValidator: (value) => {
        if (!value || value.trim() === '') {
          return 'Rejection reason is required!';
        }
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const reason = result.value;
        updateStatus(admissionId, 'Interview Failed', reason, email, first_name, last_name);
      }
    });
  }

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