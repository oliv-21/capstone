<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>View Student | Brightside</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css'); ?>">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- Custom CSS -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">


<style>
  html, body { height: 100%; margin: 0; }
  body {
    background-color: #f8f9fc;
    font-family: 'Nunito', sans-serif;
    overflow-y: auto;
    overflow-x: hidden;
  }
  .container { padding-top: 2rem; padding-bottom: 4rem; }
  .card { border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: box-shadow 0.3s ease; }
  .card:hover { box-shadow: 0 6px 18px rgba(0,0,0,0.15); }
  .section-title { color: #0d6efd; font-weight:700; margin-bottom:1rem; display:flex; align-items:center; }
  .section-title i { margin-right:0.5rem; }

  .student-photo { width:150px; height:150px; object-fit:cover; border:3px solid #0d6efd; border-radius:50%; }
  .btn { transition: background-color 0.3s ease, border-color 0.3s ease; }
  .btn:hover { filter: brightness(1.05); }

  /* Stepper Styles */
  .stepper { position: relative; margin-bottom: 2rem; }
  .stepper-item { display:flex; align-items:center; margin-bottom:1.5rem; position:relative; cursor:pointer; padding:6px 8px; border-radius:6px; }
  .stepper-item:hover { background: rgba(13,110,253,0.04); }
  .stepper-item::before { content:''; position:absolute; left:10px; top:50%; transform:translateY(-50%); width:2px; height:100%; background-color:#dee2e6; z-index:0; }
  .stepper-item:last-child::before { height:0; }
  .stepper-icon { width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; z-index:1; margin-right:10px; }
  .stepper-icon.completed { background-color:#0d6efd; color:white; border:2px solid #0d6efd; }
  .stepper-icon.in-progress { background-color:#ffc107; color:white; border:2px solid #ffc107; }
  .stepper-icon.not-started { background-color:#e9ecef; color:#6c757d; border:2px solid #dee2e6; }
  .stepper-icon.failed { background-color:#dc3545; color:white; border:2px solid #dc3545; }
  .stepper-icon.processing { background-color:#0dcaf0; color:white; border:2px solid #0dcaf0; animation: pulse 1.5s infinite; }

  @keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(13,202,240,0.6); }
    70% { box-shadow: 0 0 0 10px rgba(13,202,240,0); }
    100% { box-shadow: 0 0 0 0 rgba(13,202,240,0); }
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
          <a href="<?= base_url('guardian/dashboard'); ?>" class="nav-link d-flex align-items-center active">
            <i class="fas fa-child me-4 fa-lg fa-fw text-secondary"></i>
            Admission
          </a>
          <a href="<?= base_url('/guardian-announcement/'. esc($guardian->user_id)); ?>" class="nav-link d-flex align-items-center  <?= !$hasChildren ? 'disabled-link' : '' ?> ">

            <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i>
            <?php if ($unread_announcement > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= $unread_announcement ?>
              </span>
            <?php endif; ?>
            Announcement
          </a>
          <a href="<?= base_url('/payment-history/'. esc($guardian->user_id)); ?>" class="nav-link d-flex align-items-center <?= !$hasChildren ? 'disabled-link' : '' ?> ">
            <i class="fa-solid fa-money-bill me-4 fa-lg fa-fw text-secondary"></i> Payment
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
            <!-- Notifications -->
            <div class="dropdown me-3 position-relative border-start border-2 ps-3">
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false"
                onclick="">
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
                 <img  src="<?= base_url('public/assets/profilepic/' . esc($guardian->profile_pic)) ?>"  alt="Profile Picture"
                    class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2"><?= esc($guardian->full_name) ?></span>
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
      
      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <div class="text-start mb-4">
          <a href="<?= base_url('guardian/dashboard'); ?>" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="fa-solid fa-arrow-left me-2"></i>Back
          </a>
          <h4 class="text-primary fw-bold">Student Profile</h4>
          <p class="text-muted">View detailed student and enrollment information</p>
        </div>

        <div class="row">
          <!-- Left Column: Progress Report -->
          <div class="col-md-4">
            <div class="card shadow-sm p-4">
              <h5 class="section-title"><i class="fa-solid fa-tasks"></i> Enrollment Progress</h5>

              <?php
              $steps = [
                  'Admission' => 'not-started',
                  'Admission Approve' => 'not-started',
                  'Interview' => 'not-started',
                  'Payment' => 'not-started',
                  'Enrolled' => 'not-started'
              ];

              $status = $student->status ?? 'Pending';

              switch ($status) {
                  case 'Pending':
                      $steps['Admission'] = 'completed';
                      $steps['Admission Approve'] = 'processing';
                      break;
                  case 'Disapproved':
                      $steps['Admission'] = 'completed';
                      $steps['Admission Approve'] = 'failed';
                      break;
                  case 'Approved':
                      $steps['Admission'] = 'completed';
                      $steps['Admission Approve'] = 'completed';
                      $steps['Interview'] = 'processing';
                      break;
                  case 'Interview Failed':
                      $steps['Admission'] = 'completed';
                      $steps['Admission Approve'] = 'completed';
                      $steps['Interview'] = 'failed';
                      break;
                  case 'Pre-enrollee':
                      $steps['Admission'] = 'completed';
                      $steps['Admission Approve'] = 'completed';
                      $steps['Interview'] = 'completed';
                      $steps['Payment'] = 'processing';
                      break;
                  case 'Enrolled':
                      foreach ($steps as $key => $val) $steps[$key] = 'completed';
                      break;
              }
              ?>

              <div class="stepper">
                <?php foreach ($steps as $stepName => $stepStatus): ?>
                  <div class="stepper-item" data-step="<?= esc($stepName) ?>">
                    <div class="stepper-icon <?= esc($stepStatus) ?>">
                      <?php if($stepStatus == 'completed'): ?>
                        <i class="fa-solid fa-check"></i>
                      <?php elseif($stepStatus == 'failed'): ?>
                        <i class="fa-solid fa-xmark"></i>
                      <?php elseif($stepStatus == 'processing'): ?>
                        <i class="fa-solid fa-spinner fa-spin"></i>
                      <?php else: ?>
                        <i class="fa-solid fa-minus"></i>
                      <?php endif; ?>
                    </div>
                    <div class="ms-2">
                      <h6 class="mb-0"><?= esc($stepName) ?></h6>
                      <small class="text-muted"><?= ucfirst(str_replace('-', ' ', $stepStatus)) ?></small>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>


          <!-- Right Column: Student Profile -->
          <div class="col-md-8">
            <div class="card shadow-sm border-2 p-4">
              <img src="<?= base_url('public/assets/profilepic/' . (!empty($student->picture) ? esc($student->picture) : 'default.webp')) ?>"
                  alt="Student Photo" class="student-photo mb-3 mx-auto">

              <h5 class="fw-bold mb-5 mx-auto"><?= esc($student->full_name ?? 'N/A') ?></h5>

              <span class="badge <?= (($student->status ?? 'Pending') == 'Approved' || ($student->status ?? 'Pending') == 'Pre-enrollee') ? 'bg-success' : 'bg-secondary' ?> me-2">
                <?= esc($student->status ?? 'Pending') ?>
              </span>

              <!-- IMPORTANT: These three sections exist always (use .collapse) so JS can toggle them safely -->
              
              <!-- Admission (basic personal info) -->
              <div id="admission-section" class="collapse">
                <hr class="my-4">
                <div class="text-start">
                  <h5 class="section-title mb-4 text-primary"><i class="fa-solid fa-child"></i> Children Information</h5>
                  <div class="row">
                    <div class="col-md-4 mb-3">
                        <h6 class="text-secondary fw-bold mb-1">First Name</h6>
                        <p><?= esc($student->first_name?? 'N/A') ?></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h6 class="text-secondary fw-bold mb-1">Middle Name</h6>
                        <p><?= esc($student->middle_name?? 'N/A') ?></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h6 class="text-secondary fw-bold mb-1">Last Name</h6>
                        <p><?= esc($student->last_name?? 'N/A') ?></p>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <h6 class="text-secondary fw-bold mb-1">Nickname</h6>
                      <p><?= esc($student->nickname ?? 'N/A') ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                      <h6 class="text-secondary fw-bold mb-1">Birthdate</h6>
                      <p><?= esc($student->birthday ?? 'N/A') ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                      <h6 class="text-secondary fw-bold mb-1">Gender</h6>
                      <p><?= esc($student->gender ?? 'N/A') ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                      <h6 class="text-secondary fw-bold mb-1">Nationality</h6>
                      <p><?= esc($student->nationality ?? 'N/A') ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                      <h6 class="text-secondary fw-bold mb-1">Age</h6>
                      <p><?= esc($student->age ?? 'N/A') ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                      <h6 class="text-secondary fw-bold mb-1">Contact No.</h6>
                      <p><?= esc($student->contact_number ?? 'N/A') ?></p>
                    </div>

                    <div class="col-md-12 mb-3">
                      <h6 class="text-secondary fw-bold mb-1">Address</h6>
                      <p><?= esc($student->address ?? 'N/A') ?></p>
                    </div>

                    <div class="col-md-12 mb-3">
                      <h6 class="text-secondary fw-bold mb-1">PSA</h6>
                      <?php if (!empty($student->psa)): ?>
                        <?php $fileExtension = pathinfo($student->psa, PATHINFO_EXTENSION); ?>
                        <?php $isImage = in_array(strtolower($fileExtension), ['jpg','jpeg','png','gif','webp']); ?>
                        <?php if ($isImage): ?>
                          <img src="<?= base_url('public/assets/psa/' . esc($student->psa)) ?>" class="img-fluid rounded border" width="200" alt="PSA">
                        <?php else: ?>
                          <a href="<?= base_url('public/assets/psa/' . esc($student->psa)) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fa-solid fa-file-arrow-down me-1"></i> View / Download PSA
                          </a>
                        <?php endif; ?>
                      <?php else: ?>
                        <p>N/A</p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <!-- Parent Information -->
                  <hr class="my-4">
                  <div class="text-start">
                    <h5 class="section-title mb-4 text-primary"><i class="fa-solid fa-users me-2"></i>Parent Information</h5>
                    
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <h6 class="text-secondary fw-bold mb-1">Father's Name</h6>
                        <p><?= esc($student->father_name ?? 'N/A') ?></p>
                      </div>

                      <div class="col-md-6 mb-3">
                        <h6 class="text-secondary fw-bold mb-1">Father's Occupation</h6>
                        <p><?= esc($student->father_occupation ?? 'N/A') ?></p>
                      </div>

                      <div class="col-md-6 mb-3">
                        <h6 class="text-secondary fw-bold mb-1">Mother's Name</h6>
                        <p><?= esc($student->mother_name ?? 'N/A') ?></p>
                      </div>
                    
                      <div class="col-md-6 mb-3">
                        <h6 class="text-secondary fw-bold mb-1">Mother's Occupation</h6>
                        <p><?= esc($student->mother_occupation ?? 'N/A') ?></p>
                      </div>
                      
                    </div>
                  </div>

                  <hr class="my-4">
                    <div class="text-start">
                      <h5 class="section-title mb-4 text-primary"><i class="fa-solid fa-graduation-cap me-2"></i>Class Information</h5>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <h6 class="text-secondary fw-bold mb-1">Admission ID</h6>
                          <p><?= esc($student->admission_id ?? 'N/A') ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                          <h6 class="text-secondary fw-bold mb-1">Class Applied</h6>
                          <p><?= esc($student->class_applied ?? 'N/A') ?></p>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            
              <div id="admission-approve-section" class="collapse text-center mt-3">
                  <?php if ($status === 'Approved' || $status === 'Pre-enrollee'): ?>
                      <div class="alert alert-primary mx-auto" role="alert" style="max-width: 500px;">
                          <p class="mb-1">
                              🎉 <strong>Congratulations!</strong> Your child's admission has been <strong>approved.</strong>
                          </p>
                          <p class="mb-0">
                              You can now proceed to the <strong>interview section</strong> for the next step of the enrollment process.
                          </p>
                      </div>
                  <?php elseif ($status === 'Disapproved'): ?>
                      <div class="alert alert-danger mx-auto" role="alert" style="max-width: 500px;">
                          <p class="mb-1">We regret to inform you that your child’s application was <strong>not approved</strong>.</p>
                          <p class="mb-0">You may contact our admission office for further assistance.</p>
                          <p class="mb-0"> Reason: <?= esc($student->reason ?? 'N/A') ?></p>
                      </div>
                  <?php elseif ($status === 'Pending'): ?>
                      <div class="alert alert-info mx-auto" role="alert" style="max-width: 500px;">
                          <p class="mb-1">Please note: your application is under evaluation.</p>
                      </div>
                  <?php elseif ($status === 'Enrolled'): ?>
                      <div class="alert alert-primary mx-auto" role="alert" style="max-width: 500px;">
                          <p class="mb-1">
                              🎉 <strong>Congratulations!</strong> Your child's admission has been <strong>approved.</strong>
                          </p>
                          <p class="mb-0">
                              You can now proceed to the <strong>interview section</strong> for the next step of the enrollment process.
                          </p>
                      </div>
                  <?php endif; ?>
              </div>

              <!-- Interview section (for interview-specific details) -->
              <div id="interview-section" class="collapse">
                <hr class="my-4">
                <h5 class="section-title mb-4 text-primary"><i class="fa-solid fa-graduation-cap"></i> Interview / Next Steps</h5>
                <?php if (($student->status ?? 'Pending') === 'Approved'): ?>
                  <div class="alert alert-primary mt-3" role="alert">
                    <p class="mb-1">Your child’s enrollment schedule is available from <strong>Monday to Friday, 8:00 AM to 4:00 PM</strong>.</p>
                    <p class="mb-1">Please come for the scheduled interview.</p>
                    <p class="mb-0">For more details or further inquiries, you may contact the school via chat or send an email to Brightside@gmail.com</p>

                  </div>
                  <div class="alert alert-warning mt-2" role="alert">
                    <p class="mb-0"><strong>Reminder:</strong> Failure to attend the interview schedule may result in disqualification from enrollment.</p>
                  </div>
                  <?php endif; ?>

                  <?php if (($student->status ?? 'Pending') === 'Interview Failed'): ?>
                    <div class="alert alert-danger mt-3 shadow-sm border-0 rounded-3" role="alert" style="background: #f8d7da;">
                      <h6 class="fw-bold text-danger mb-2"><i class="fa-solid fa-triangle-exclamation me-2"></i> Interview Result</h6>
                      <p class="mb-1">We regret to inform you that <strong>your child did not pass the interview process.</strong></p>
                      <p class="mb-1">For detailed feedback or further assistance, please reach out to our <strong>Admission Office</strong>.</p>
                      <p class="mb-0"><i class="fa-solid fa-envelope me-2"></i><strong>Kindly check your registered email</strong> for additional information.</p>
                    </div>

                  <?php elseif (($student->status ?? 'Pending') === 'Pre-enrollee'): ?>
                    <p class="mb-1"><strong>Congratulations!</strong> Your child has passed the interview. Please proceed to pay the enrollment fee to complete the enrollment process.</p>
                  <?php endif; ?>
              </div>

              <div id="payment-section" class="collapse">
                <hr class="my-4">
                <h5 class="section-title"> <i class="fa-solid fa-credit-card"></i> Pay Online</h5>
                <?php if (($student->status ?? 'Pending') === 'Approved'): ?>
                  <div class="alert alert-primary mt-3" role="alert">
                    <p class="mb-1">Your child’s enrollment schedule is available from <strong>Monday to Friday, 8:00 AM to 4:00 PM</strong>.</p>
                    <p class="mb-0">Please come for the scheduled interview.</p>
                  </div>
                  <div class="alert alert-warning mt-2" role="alert">
                    <p class="mb-0"><strong>Reminder:</strong> Failure to attend the interview schedule may result in disqualification from enrollment.</p>
                  </div>
                  <?php endif; ?>

                  <?php if (($student->status ?? 'Pending') === 'Interview Failed'): ?>
                    <div class="alert alert-danger mt-3 shadow-sm border-0 rounded-3" role="alert" style="background: #f8d7da;">
                      <h6 class="fw-bold text-danger mb-2"><i class="fa-solid fa-triangle-exclamation me-2"></i> Interview Result</h6>
                      <p class="mb-1">We regret to inform you that <strong>your child did not pass the interview process.</strong></p>
                      <p class="mb-1">For detailed feedback or further assistance, please reach out to our <strong>Admission Office</strong>.</p>
                      <p class="mb-0"><i class="fa-solid fa-envelope me-2"></i><strong>Kindly check your registered email</strong> for additional information.</p>
                    </div>



                  <?php elseif (($student->status ?? 'Pending') === 'Pre-enrollee'): ?>
                    
                    <form action="<?= base_url('user/create_payment_link'); ?>" method="POST" id="paymentForm">
                      <div class="mb-3">
                          <label class="form-label fw-bold">Student</label>
                          <input type="text" class="form-control" name="studentName" value="<?= esc($student->full_name); ?>" readonly>
                          <input type="hidden" name="student_id" value="<?= esc($student->admission_id); ?>">
                      </div>

                      <div class="mb-3">
                          <label for="paymentDate" class="form-label fw-bold">Payment Date</label>
                          <input type="date" class="form-control" id="paymentDate" name="payment_date" readonly value="<?= date('Y-m-d'); ?>" required>
                      </div>

                      <div class="mb-3">
                          <label class="form-label fw-bold">Payment Method</label>
                          <div>
                              <input type="radio" name="paymentMethod" value="gcash" id="gcash">
                              <label for="gcash" class='me-3'>Gcash</label>

                              <input type="radio" name="paymentMethod" value="paymaya" id="paymaya">
                              <label for="paymaya" class='me-3'>PayMaya</label>

                              <input type="radio" name="paymentMethod" value="card" id="card">
                              <label for="card" class='me-3'>Card</label>

                              <input type="radio" name="paymentMethod" value="dob" id="dob">
                              <label for="dob" >Direct Online Bank</label>
                          </div>
                      </div>

                      <!-- Container for dynamic payment details -->
                      <div id="paymentDetails" style="display:none;"></div>

                      
                    </form>
                  <?php elseif (($student->status ?? 'Pending') === 'Enrolled'): ?>
                    <p class="mb-1">
                      🎉 <strong>Congratulations!</strong> Your payment <strong>accepted.</strong>
                    </p>
                  <p class="mb-0">
                    
                  <?php endif; ?>
              </div>

              <!-- Buttons -->
              <hr class="my-4">
                <?php
                  $status = $student->status ?? '';
                  $hideButtons = in_array($status, ['Enrolled', 'Pre-enrollee', 'Interview Failed']);
                ?>
              <div class="d-flex justify-content-center gap-2 flex-wrap" >
                <?php if (!$hideButtons): ?>
                  <a   href="<?= base_url('guardian/edit-student/' . $student->admission_id) ?>" class="btn btn-primary">
                    <i class="fa-solid fa-pen me-1"></i>Edit
                  </a>
                
                  <a  href="#" class="btn btn-outline-danger delete-student-btn" data-id="<?= $student->admission_id; ?>">
                      <i class="fa-solid fa-trash me-1"></i> Delete
                  </a>
                <?php endif; ?>

                <!-- <a href="<?= base_url('guardian/dashboard'); ?>" class="btn btn-outline-secondary">
                  <i class="fa-solid fa-arrow-left me-1"></i>Back
                </a> -->
              </div>

            </div>
          </div>
        </div>
      </main>

      
    </div>

    <!-- Bootstrap JS -->
    <script src="<?= base_url('dist/js/bootstrap.bundle.min.js'); ?>"></script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // map stepName -> element id (must match data-step on stepper items)
        const sections = {
          'Admission': document.getElementById('admission-section'),
          'Admission Approve': document.getElementById('admission-approve-section'),
          'Interview': document.getElementById('interview-section'),
          'Payment': document.getElementById('payment-section')
        };

        function showSection(stepName) {
          Object.keys(sections).forEach(key => {
            const section = sections[key];
            if (!section) return;
            const instance = bootstrap.Collapse.getOrCreateInstance(section, {toggle:false});
            if (key === stepName) {
              instance.show();
            } else {
              instance.hide();
            }
          });

          // highlight active step visually
          document.querySelectorAll('.stepper-item').forEach(item => {
            if (item.dataset.step === stepName) item.classList.add('active-step');
            else item.classList.remove('active-step');
          });
        }

        // Determine current step from PHP status
        const currentStatus = "<?= esc($student->status ?? 'Pending') ?>";
        let currentStep = 'Admission';
        switch (currentStatus) {
          case 'Pending': currentStep = 'Admission'; break;
          case 'Approved': currentStep = 'Admission Approve'; break;
          case 'Pre-enrollee': currentStep = 'Interview'; break;
          case 'Interview Failed': currentStep = 'Interview'; break;
          case 'Enrolled': currentStep = 'Admission Approve'; break;
          case 'Disapproved': currentStep = 'Admission'; break;
          default: currentStep = 'Admission'; break;
        }

        // Auto-show the appropriate section on load
        if (sections[currentStep]) showSection(currentStep);

        // Add click listeners to stepper items for manual switching
        document.querySelectorAll('.stepper-item').forEach(item => {
          item.addEventListener('click', function() {
            const stepName = this.dataset.step;
            if (stepName && sections[stepName]) showSection(stepName);
          });
        });
      });


      document.querySelectorAll('input[name="paymentMethod"]').forEach((elem) => {
        elem.addEventListener("change", function () {
            const details = document.getElementById("paymentDetails");
            let content = "";

            const amount = <?= json_encode($amount ?? 2000); ?>; // Default to 2000 if $amount undefined

            if (this.value === "gcash" || this.value === "paymaya") {
                content = `
                  <div class="mb-3">
                    <label for="payamount" class="form-label">Amount to Pay (Enrollment Fee) </label>
                    <input type="text" class="form-control" id="payamount" name="payamount"
                      value="${parseFloat(amount).toFixed(2)}" readonly>
                  </div>
                  <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name (Gcash/PayMaya Owner)</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                  </div>
                  <div class="mb-3">
                    <label for="number" class="form-label">Gcash/PayMaya Number</label>
                    <input type="number" class="form-control" id="number" name="number" required>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email Address (for receipt)</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                  <button type="submit" class="btn btn-success w-100">Pay Now via PayMongo</button>
                `;
            } else if (this.value === "card") {
                content = `
                  <div class="mb-3">
                    <label for="payamount" class="form-label">Amount to Pay</label>
                    <input type="text" class="form-control" id="payamount" name="payamount"
                      value="${parseFloat(amount).toFixed(2)}" readonly>
                  </div>
                  <div class="mb-3">
                    <label for="cardNumber" class="form-label">Card Number</label>
                    <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
                  </div>
                  <div class="mb-3">
                    <label for="expiryMonth" class="form-label">Month Date</label>
                    <input type="number" class="form-control" id="expiryMonth" name="expiryMonth" 
                          placeholder="MM(e.g 01)" min="1" max="12" required>
                  </div>
                  <div class="mb-3">
                    <label for="expiryYear" class="form-label">Year Date</label>
                    <input type="number" class="form-control" id="expiryYear" name="expiryYear" 
                          placeholder="YYYY(eg 2026)" min="2025" max="2100" required>
                  </div>
                  <div class="mb-3">
                    <label for="cvv" class="form-label">CVV</label>
                    <input type="number" class="form-control" id="cvv" name="cvv" required>
                  </div>
                  <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" >
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email Address(for receipt)</label>
                    <input type="email" class="form-control" id="email" name="email" >
                  </div>
                  <button type="submit" class="btn btn-success w-100">Pay Now via Card</button>
                `;
            } else if (this.value === "dob") {
                content = `
                  <div class="mb-3">
                    <label for="payamount" class="form-label">Amount to Pay</label>
                    <input type="text" class="form-control" id="payamount" name="payamount"
                      value="${parseFloat(amount).toFixed(2)}" readonly>
                  </div>
                  <div class="mb-3">
                    <label for="accountName" class="form-label">Select Bank</label>
                    <select class="form-select" id="accountName" name="accountName" required>
                      <option value="">-- Select Bank --</option>
                      <option value="test_bank_one">BPI (Test)</option>
                      <option value="test_bank_two">UnionBank (Test)</option>
                      <option value="bdo">BDO (not available or testing)</option>
                      <option value="metrobank">Metrobank (not available or testing)</option>
                      <option value="landbank">Landbank (not available or testing)</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" >
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email Address(for receipt)</label>
                    <input type="email" class="form-control" id="email" name="email" >
                  </div>
                  <button type="submit" class="btn btn-success w-100">Pay Now via DOB</button>
                `;
            }

            details.innerHTML = content;
            details.style.display = "block";
        });
    });
    </script>
    
    <script>
      document.querySelectorAll('.delete-student-btn').forEach(button => {
          button.addEventListener('click', function(e) {
              e.preventDefault();
              const studentId = this.dataset.id;

              Swal.fire({
                  title: 'Are you sure?',
                  text: "This student will be permanently deleted!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!',
                  cancelButtonText: 'Cancel'
              }).then((result) => {
                  if (result.isConfirmed) {
                      // Redirect to delete URL
                      window.location.href = "<?= base_url('guardian/delete-student/'); ?>" + studentId;
                  }
              });
          });
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

    </script>

  </div>
</body>
</html>
