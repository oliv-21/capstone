<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Progress Report</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="../assets/img/logoicon.png" rel="icon" />
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/admin.css">
</head>

<body>
  <div class="wrapper d-flex">
    <!-- Sidebar -->
    <nav id="teacherSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img id="schoolLogo" src="<?= base_url(); ?>assets/img/logoicon.png" alt="Logo" class="me-3 ms-1" style="width: 38px;">
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
        <a href="<?= base_url(); ?>teacher-grades" class="nav-link d-flex align-items-center active">
          <i class="fas fa-calendar-check me-4 fa-lg fa-fw text-secondary"></i> Progress Report
        </a>
        <a href="<?= base_url(); ?>teacher-materials" class="nav-link d-flex align-items-center">
          <i class="fas fa-book me-4 fa-lg fa-fw text-secondary"></i> Materials
        </a>
        <a href="<?= base_url(); ?>teacher-annoucement" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-bell me-4 fa-lg fa-fw text-secondary"></i> Announcements
        </a>
         <a href="<?= base_url(); ?>teacher-interactive-learning" class="nav-link d-flex align-items-center ">
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
            <div class="dropdown me-3 position-relative border-start border-2 ps-3 ">
              
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                <!-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">2</span> -->
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm overflow-auto" aria-labelledby="notifDropdown"
                style="width: 350px; max-height:320px;">
                <li class="dropdown-header fw-bold">Notifications</li>
                <li><hr class="dropdown-divider"></li>
                <li class="px-3 py-2 small">
                  <strong>New Assignment</strong><br>
                  <span class="text-muted">Math worksheet uploaded.</span>
                </li>
                <li class="px-3 py-2 small">
                  <strong>New Message</strong><br>
                  <span class="text-muted">Parent sent a message.</span>
                </li>
              </ul>
            </div>
            <div class="me-3 position-relative border-start border-2 ps-3">
              <a href="<?= base_url(); ?>teacher-chats" class="text-decoration-none text-primary">
                <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
              </a>
            </div>
            <!-- Profile -->
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

      <!-- Page Content -->
      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <div class="d-flex align-items-center">
          <h2 class="mb-4 "> <a class="text-primary" href="<?= base_url(); ?>teacher-grades"><i Class="fas fa-arrow-left me-3"></i></a></h2>
          <h2 class="mb-4 text-primary">Progress Report</h2>
        </div>
        <div class="card border-0 shadow-sm p-3 mb-4">
          <div class="card-body d-flex justify-content-between align-items-start flex-wrap">
            <!-- Left: Student Info -->
            <div>
              <h6 class="text-muted mb-3">
                <i class="fa-solid fa-user-graduate me-2 text-primary"></i><strong>Student Information</strong>
              </h6>
              <div class="d-flex mb-2">
                <span class="fw-semibold text-secondary" style="width: 80px;">
                  Student:
                </span>
                <span><?= esc($studentData['full_name']) ?></span>
              </div>
              <div class="d-flex">
                <span class="fw-semibold text-secondary" style="width: 80px;">
                  Class:
                </span>
                <span><?= esc($studentData['class_level']) ?></span>
              </div>
            </div>

            <!-- Right: Quarter Selector -->
            <div class="text-end" style="min-width: 220px;">
              <h6 class="text-muted mb-3 text-start">
                <i class="fa-solid fa-calendar-days me-2 text-primary"></i><strong>Quarter</strong>
              </h6>
              <select class="form-select form-select-sm w-100" name="quarter_select" id="quarter_select" required>
                <?php $selectedQuarter = ''; ?>
                <option value="" disabled <?= empty($selectedQuarter) ? 'selected' : '' ?>>Choose Quarter</option>
                <option value="1" <?= ($selectedQuarter == 1) ? 'selected' : '' ?>>1st Quarter</option>
                <option value="2" <?= ($selectedQuarter == 2) ? 'selected' : '' ?>>2nd Quarter</option>
                <option value="3" <?= ($selectedQuarter == 3) ? 'selected' : '' ?>>3rd Quarter</option>
                <option value="4" <?= ($selectedQuarter == 4) ? 'selected' : '' ?>>4th Quarter</option>
              </select>
            </div>

          </div>
        </div>





        <form id="progressForm"  method = 'post' action="<?= base_url('/teacher-progress-report-post/'.$studentData['user_id']) ?>" class="mt-4">
           <input type="hidden" name="student_id" value="<?= esc($studentData['user_id']); ?>">
            <input type="hidden" name="quarter" id="quarter_hidden" value="<?= isset($studentAssessmentData->quarter) ? $studentAssessmentData->quarter : '' ?>">
          <div class="container d-flex justify-content-center border border-1 border-warning p-2 rounded shadow-sm">
            <ul class="list-inline m-0">
              <li class="list-inline-item me-4">⭐⭐⭐⭐⭐ = <strong>Excellent</strong></li>
              <li class="list-inline-item me-4">⭐⭐⭐⭐ = <strong>Very Good</strong></li>
              <li class="list-inline-item me-4">⭐⭐⭐ = <strong>Good</strong></li>
              <li class="list-inline-item me-4">⭐⭐ = <strong>Average</strong></li>
              <li class="list-inline-item">⭐ = <strong>Needs Improvement</strong></li>
            </ul>
          </div>
          <!-- Progress Bar -->
          <div class="progress my-3" style="height: 20px;">
            <div id="progressBar"
              class="progress-bar bg-primary fw-bold"
              role="progressbar"
              style="width: 16%;"
              aria-valuenow="1"
              aria-valuemin="0"
              aria-valuemax="6">
              Step 1 of 6
            </div>
          </div>

          <!-- STEP CONTENTS -->
          <div class="card shadow-sm rounded-3">
            <div class="card-body">

              <!-- Step 1: Social - Emotional -->
              <div class="step" id="step-1">
                <h5 class="mb-3 text-primary fw-bold"><i class="fas fa-users me-2 text-secondary"></i> Social - Emotional</h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light"><tr><th>Criteria</th><th class="text-center">Assessment</th></tr></thead>
                    <tbody>
                      <tr>
                          <td>Getting along with others</td>
                          <td class="text-center">
                            <select name="criteria[1]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Gets use of school daily routines</td>
                          <td class="text-center">
                            <select name="criteria[2]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Builds Self-Confidence</td>
                          <td class="text-center">
                            <select name="criteria[3]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Plays Cooperative</td>
                          <td class="text-center">
                            <select name="criteria[4]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Practice patience in doing the activity</td>
                          <td class="text-center">
                            <select name="criteria[5]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Builds good behavior with others</td>
                          <td class="text-center">
                            <select name="criteria[6]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Express feelings with simple words</td>
                          <td class="text-center">
                            <select name="criteria[7]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Smiles socially</td>
                          <td class="text-center">
                            <select name="criteria[8]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Develops attachment and trust to others</td>
                          <td class="text-center">
                            <select name="criteria[9]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>

                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Step 2: Practice Life (Ground Rules) -->
              <div class="step d-none" id="step-2">
                <h5 class="mb-3 text-primary fw-bold"><i class="fas fa-child me-2 text-secondary"></i> Practice Life (Ground Rules)</h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light"><tr><th>Criteria</th><th class="text-center">Assessment</th></tr></thead>
                    <tbody>
                      <tr>
                        <td>Cross legs during circle time</td>
                        <td class="text-center">
                          <select name="criteria[10]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Sits on the chair with care</td>
                        <td class="text-center">
                          <select name="criteria[11]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Walks on the line</td>
                        <td class="text-center">
                          <select name="criteria[12]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Lines up with patience</td>
                        <td class="text-center">
                          <select name="criteria[13]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Recognizes own bag and belongings</td>
                        <td class="text-center">
                          <select name="criteria[14]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Carry things with independence</td>
                        <td class="text-center">
                          <select name="criteria[15]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                    </tbody>

                  </table>
                </div>
              </div>

              <!-- Step 3: Fine Motor Skills (Eye-Hand Coordination) -->
              <div class="step d-none" id="step-3">
                <h5 class="mb-3 text-primary fw-bold"><i class="fas fa-hand-paper me-2 text-secondary"></i> Fine Motor Skills (Eye-Hand Coordination)</h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light"><tr><th>Criteria</th><th class="text-center">Assessment</th></tr></thead>
                    <tbody>
                        <tr>
                          <td>Squeezing toys with firmness</td>
                          <td class="text-center">
                            <select name="criteria[16]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Presses and rolls playdough with firmness</td>
                          <td class="text-center">
                            <select name="criteria[17]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Stacking sticks in the designated holes</td>
                          <td class="text-center">
                            <select name="criteria[18]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>String large beads</td>
                          <td class="text-center">
                            <select name="criteria[19]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Place shapes in the right slots</td>
                          <td class="text-center">
                            <select name="criteria[20]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Bangs two toys together to create sounds</td>
                          <td class="text-center">
                            <select name="criteria[21]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Bangs hands on the table with coordination</td>
                          <td class="text-center">
                            <select name="criteria[22]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Assembles/Builds pink tower (sand, water)</td>
                          <td class="text-center">
                            <select name="criteria[23]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Performs pouring exercises</td>
                          <td class="text-center">
                            <select name="criteria[24]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Display grip in tongs exercise</td>
                          <td class="text-center">
                            <select name="criteria[25]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Grasps pencil, crayon with interest</td>
                          <td class="text-center">
                            <select name="criteria[26]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Performs pasting with eye-hand coordination</td>
                          <td class="text-center">
                            <select name="criteria[27]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                      </tbody>

                  </table>
                </div>
              </div>

              <!-- Step 4: Gross Motor Skills -->
              <div class="step d-none" id="step-4">
                <h5 class="mb-3 text-primary fw-bold"><i class="fas fa-running me-2 text-secondary"></i> Gross Motor Skills</h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light"><tr><th>Criteria</th><th class="text-center">Assessment</th></tr></thead>
                    <tbody>
                        <tr>
                          <td>Walks with firm legs</td>
                          <td class="text-center">
                            <select name="criteria[28]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Perform stepping exercise on steppers</td>
                          <td class="text-center">
                            <select name="criteria[29]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Bend Body with balance</td>
                          <td class="text-center">
                            <select name="criteria[30]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Sits and stands up with balance</td>
                          <td class="text-center">
                            <select name="criteria[31]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Stands on foot at 2-3 counts</td>
                          <td class="text-center">
                            <select name="criteria[32]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Bounce and rolls the ball</td>
                          <td class="text-center">
                            <select name="criteria[33]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Kicking the ball with legs coordination</td>
                          <td class="text-center">
                            <select name="criteria[34]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Sticking pictures on designated area</td>
                          <td class="text-center">
                            <select name="criteria[35]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Catches, throws and kicks the ball with direction</td>
                          <td class="text-center">
                            <select name="criteria[36]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Dances with sense of rhythm</td>
                          <td class="text-center">
                            <select name="criteria[37]" class="form-select form-select-sm">
                              <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                              <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                              <option value="Good">⭐⭐⭐ Good</option>
                              <option value="Average">⭐⭐ Average</option>
                              <option value="Needs Improvement">⭐ Needs Improvement</option>
                            </select>
                          </td>
                        </tr>
                      </tbody>

                  </table>
                </div>
              </div>

              <!-- Step 5: Sensory Skills -->
              <div class="step d-none" id="step-5">
                <h5 class="mb-3 text-primary fw-bold"><i class="fas fa-brain me-2 text-secondary"></i> Sensory Skills</h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light"><tr><th>Criteria</th><th class="text-center">Assessment</th></tr></thead>
                    <tbody>
                      <tr>
                        <td>Listen attentively</td>
                        <td class="text-center">
                          <select name="criteria[38]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Develops sensory skills to identify hard and soft objects</td>
                        <td class="text-center">
                          <select name="criteria[39]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Recognize light and heavy objects</td>
                        <td class="text-center">
                          <select name="criteria[40]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Matches object to similar colors</td>
                        <td class="text-center">
                          <select name="criteria[41]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Develops hearing response on loud and soft sounds</td>
                        <td class="text-center">
                          <select name="criteria[42]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Responds to smelling exercises</td>
                        <td class="text-center">
                          <select name="criteria[43]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                    </tbody>

                  </table>
                </div>
              </div>

              <!-- Step 6: Language Development -->
              <div class="step d-none" id="step-6">
                <h5 class="mb-3 text-primary fw-bold"><i class="fas fa-language me-2 text-secondary"></i> Language Development</h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light"><tr><th>Criteria</th><th class="text-center">Assessment</th></tr></thead>
                    <tbody>
                      <tr>
                        <td>Greets with simple words</td>
                        <td class="text-center">
                          <select name="criteria[44]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Head turns or nods when name is called</td>
                        <td class="text-center">
                          <select name="criteria[45]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Says own name</td>
                        <td class="text-center">
                          <select name="criteria[46]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Names people around</td>
                        <td class="text-center">
                          <select name="criteria[47]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Recognize family members</td>
                        <td class="text-center">
                          <select name="criteria[48]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Points parts of the body</td>
                        <td class="text-center">
                          <select name="criteria[49]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Recognize common fruits</td>
                        <td class="text-center">
                          <select name="criteria[50]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Names some common animals</td>
                        <td class="text-center">
                          <select name="criteria[51]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Names objects around</td>
                        <td class="text-center">
                          <select name="criteria[52]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Follows simple directions such as sit, down, jump, clap hands</td>
                        <td class="text-center">
                          <select name="criteria[53]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Recites finger plays and rhymes</td>
                        <td class="text-center">
                          <select name="criteria[54]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Listen during story time</td>
                        <td class="text-center">
                          <select name="criteria[55]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Shows interest in opening books</td>
                        <td class="text-center">
                          <select name="criteria[56]" class="form-select form-select-sm">
                            <option value="Excellent">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="Very Good">⭐⭐⭐⭐ Very Good</option>
                            <option value="Good">⭐⭐⭐ Good</option>
                            <option value="Average">⭐⭐ Average</option>
                            <option value="Needs Improvement">⭐ Needs Improvement</option>
                          </select>
                        </td>
                      </tr>
                    </tbody>

                  </table>
                </div>
              </div>

              <!-- Step 7: Teacher Remarks -->
              <div class="step d-none" id="step-7">
                <h5 class="mb-3 text-primary fw-bold"><i class="fas fa-pen me-2 text-secondary"></i> Teacher Remarks / Comments</h5>
                <div class="mb-3">
                  <label for="teacherRemarks" class="form-label">Remarks or Comments</label>
                  <textarea id="teacherRemarks" class="form-control" rows="6"  name="remarks" placeholder="Enter your remarks or comments here"><?= isset($remarks[1]) ? esc($remarks[1]['remarks']) : '' ?></textarea>
                </div>
              </div>


            </div>
          </div>

          <!-- PAGINATION NAV -->
          <div class="d-flex justify-content-between align-items-center mt-3">
            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" id="prevBtn">
              <i class="fas fa-arrow-left me-1"></i> Previous
            </button>
            <button type="button" class="btn btn-primary rounded-pill px-4" id="nextBtn">
              Next <i class="fas fa-arrow-right ms-1"></i>
            </button>
          </div>
          <!-- SUBMIT -->
          <div class="text-end mt-4">
            <button type="submit" class="btn btn-success rounded-pill px-4 d-none" id="submitBtn">
              <i class="fas fa-save me-2"></i> Save Report
            </button>
          </div>
        </form>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="<?= base_url('dist/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/user.js') ?>"></script>

<!-- <script>
  // Step Navigation (Updated for 7 steps)
  const steps = document.querySelectorAll('.step');
  let currentStep = 0;
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const submitBtn = document.getElementById('submitBtn');
  const progressBar = document.getElementById('progressBar');

  function showStep(index) {
    steps.forEach((step, i) => {
      step.classList.toggle('d-none', i !== index);
    });

    prevBtn.style.display = index === 0 ? 'none' : 'inline-block';
    nextBtn.style.display = index === steps.length - 1 ? 'none' : 'inline-block';
    submitBtn.classList.toggle('d-none', index !== steps.length - 1);

    const progress = ((index + 1) / steps.length) * 100;
    progressBar.style.width = `${progress}%`;
    progressBar.innerText = `Step ${index + 1} of ${steps.length}`;
  }

  prevBtn.addEventListener('click', () => {
    if (currentStep > 0) currentStep--;
    showStep(currentStep);
  });

  // ✅ Prevent next if no quarter selected
  nextBtn.addEventListener('click', (e) => {
    const quarterSelect = document.getElementById('quarter_select');
    const selectedQuarter = quarterSelect ? quarterSelect.value.trim() : '';

    if (!selectedQuarter) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please select Quarter',
        confirmButtonColor: '#d33'
      });
      return;
    }

    if (currentStep < steps.length - 1) currentStep++;
    showStep(currentStep);
  });

  // Initialize steps
  showStep(currentStep);

  const assessmentsData = <?= json_encode($studentAssessments ?? []) ?>;
  const assessments = {};
  assessmentsData.forEach(row => {
    const q = parseInt(row.quarter);
    const cid = parseInt(row.criteria_id);
    const val = row.assessment;
    if (!assessments[q]) assessments[q] = {};
    assessments[q][cid] = val;
  });

  console.log('Loaded Assessments:', assessments); 

  function populateForm(quarter) {
    document.querySelectorAll('select[name^="criteria"]').forEach(select => {
      select.value = ''; 
    });

    

    if (!quarter || !assessments[quarter]) {
      console.log(`No saved data for Quarter ${quarter}`);
      return;
    }

    document.querySelectorAll('select[name^="criteria"]').forEach(select => {
      const nameMatch = select.name.match(/criteria\[(\d+)\]/);
      if (nameMatch) {
        const criteriaId = parseInt(nameMatch[1]);
        const savedValue = assessments[quarter][criteriaId];
        if (savedValue) select.value = savedValue;
      }
    });
  }

  document.getElementById('quarter_select').addEventListener('change', function() {
    const quarter = this.value;
    document.getElementById('quarter_hidden').value = quarter;
    populateForm(quarter);
  });

  document.addEventListener('DOMContentLoaded', function() {
    const defaultQuarter = document.getElementById('quarter_select').value;
    if (defaultQuarter) {
      populateForm(defaultQuarter);
    }
  });

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
</script>
<script>
  // // Convert PHP remarks array to JS object
  // const remarksData = <?= json_encode($remarks ?? []) ?>;

  // function populateForm(quarter) {
  //   // Clear all criteria selects
  //   document.querySelectorAll('select[name^="criteria"]').forEach(select => {
  //     select.value = '';
  //   });

  //   // Populate criteria selects for the selected quarter
  //   if (quarter && assessments[quarter]) {
  //     document.querySelectorAll('select[name^="criteria"]').forEach(select => {
  //       const nameMatch = select.name.match(/criteria\[(\d+)\]/);
  //       if (nameMatch) {
  //         const criteriaId = parseInt(nameMatch[1]);
  //         const savedValue = assessments[quarter][criteriaId];
  //         if (savedValue) select.value = savedValue;
  //       }
  //     });
  //   }

  //   // Populate Teacher Remarks for the selected quarter
  //   const remarksTextarea = document.getElementById('teacherRemarks');
  //   if (remarksTextarea) {
  //     remarksTextarea.value = remarksData[quarter] ? remarksData[quarter]['remarks'] : '';
  //   }
  // }

  // document.getElementById('quarter_select').addEventListener('change', function() {
  //   const quarter = this.value;
  //   document.getElementById('quarter_hidden').value = quarter;
  //   populateForm(quarter);
  // });

  // // Initialize on page load
  // document.addEventListener('DOMContentLoaded', function() {
  //   const defaultQuarter = document.getElementById('quarter_select').value;
  //   if (defaultQuarter) {
  //     populateForm(defaultQuarter);
  //   }
  // });
   const remarksData = <?= json_encode($remarks ?? []) ?>;

  function populateForm(quarter) {
    document.querySelectorAll('select[name^="criteria"]').forEach(select => select.value = '');

    if (quarter && assessments[quarter]) {
      document.querySelectorAll('select[name^="criteria"]').forEach(select => {
        const nameMatch = select.name.match(/criteria\[(\d+)\]/);
        if (nameMatch) {
          const criteriaId = parseInt(nameMatch[1]);
          const savedValue = assessments[quarter][criteriaId];
          if (savedValue) select.value = savedValue;
        }
      });
    }

    const remarksTextarea = document.getElementById('teacherRemarks');
    if (remarksTextarea) {
      remarksTextarea.value = remarksData[quarter] ? remarksData[quarter]['remarks'] : '';
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    const quarterSelect = document.getElementById('quarter_select');
    const form = document.getElementById('progressForm');

    // Create message element
    const messageDiv = document.createElement('div');
   messageDiv.id = 'quarterMessage';
messageDiv.innerHTML = `
  <div class="card shadow-sm border-0 mx-auto" style="max-width: 450px;">
    <div class="card-body text-center py-5">
      <i class="fas fa-exclamation-circle text-warning mb-3" style="font-size: 2.5rem;"></i>
      <h5 class="fw-bold text-secondary mb-2">Please Select a Quarter</h5>
      <p class="text-muted mb-0">Choose a quarter from the dropdown above to display the form.</p>
    </div>
  </div>
`;
    form.parentNode.insertBefore(messageDiv, form);

    // Hide form at start
    form.style.display = 'none';

    quarterSelect.addEventListener('change', function () {
      const quarter = this.value;
      document.getElementById('quarter_hidden').value = quarter;

      if (!quarter) {
        form.style.display = 'none';
        messageDiv.style.display = 'block';
        Swal.fire({
          icon: 'warning',
          title: 'No Quarter Selected',
          text: 'Please select a quarter to view or edit data.',
        });
        return;
      }

      // Show form and hide message
      form.style.display = 'block';
      messageDiv.style.display = 'none';
      populateForm(quarter);
    });
  });
</script>
 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // === Step Navigation ===
  const steps = document.querySelectorAll('.step');
  let currentStep = 0;
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const submitBtn = document.getElementById('submitBtn');
  const progressBar = document.getElementById('progressBar');

  function showStep(index) {
    steps.forEach((step, i) => {
      step.classList.toggle('d-none', i !== index);
    });

    prevBtn.style.display = index === 0 ? 'none' : 'inline-block';
    nextBtn.style.display = index === steps.length - 1 ? 'none' : 'inline-block';
    submitBtn.classList.toggle('d-none', index !== steps.length - 1);

    const progress = ((index + 1) / steps.length) * 100;
    progressBar.style.width = `${progress}%`;
    progressBar.innerText = `Step ${index + 1} of ${steps.length}`;
  }

  prevBtn.addEventListener('click', () => {
    if (currentStep > 0) currentStep--;
    showStep(currentStep);
  });

  nextBtn.addEventListener('click', (e) => {
    const quarterSelect = document.getElementById('quarter_select');
    const selectedQuarter = quarterSelect ? quarterSelect.value.trim() : '';

    if (!selectedQuarter) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please select Quarter',
        confirmButtonColor: '#d33'
      });
      return;
    }

    if (currentStep < steps.length - 1) currentStep++;
    showStep(currentStep);
  });

  showStep(currentStep);

  // === Data Initialization ===
  const assessmentsData = <?= json_encode($studentAssessments ?? []) ?>;
  const remarksData = <?= json_encode($remarks ?? []) ?>;
  const assessments = {};

  assessmentsData.forEach(row => {
    const q = parseInt(row.quarter);
    const cid = parseInt(row.criteria_id);
    const val = row.assessment;
    if (!assessments[q]) assessments[q] = {};
    assessments[q][cid] = val;
  });

  console.log('Loaded Assessments:', assessments);

  // === Populate Form ===
  function populateForm(quarter) {
    document.querySelectorAll('select[name^="criteria"]').forEach(select => select.value = '');

    if (quarter && assessments[quarter]) {
      document.querySelectorAll('select[name^="criteria"]').forEach(select => {
        const match = select.name.match(/criteria\[(\d+)\]/);
        if (match) {
          const cid = parseInt(match[1]);
          const val = assessments[quarter][cid];
          if (val) select.value = val;
        }
      });
    }

    const remarksTextarea = document.getElementById('teacherRemarks');
    if (remarksTextarea) {
      remarksTextarea.value = remarksData[quarter]?.remarks || '';
    }

    updateSubmitButton(quarter);
  }
  

  // === Update Submit Button ===
  function updateSubmitButton(quarter) {
    const submitBtn = document.getElementById('submitBtn');
    if (!quarter) {
      submitBtn.classList.add('d-none');
      return;
    }

    const hasData = assessments[quarter] && Object.keys(assessments[quarter]).length > 0;
    if (hasData) {
      submitBtn.innerHTML = `<i class="fas fa-sync-alt me-2"></i> Update Report`;
      submitBtn.classList.replace('btn-success', 'btn-primary');
    } else {
      submitBtn.innerHTML = `<i class="fas fa-save me-2"></i> Save Report`;
      submitBtn.classList.replace('btn-primary', 'btn-success');
    }
    
    

   
  }

  // === Quarter Selection Behavior ===
  // document.addEventListener('DOMContentLoaded', function () {
  //   const quarterSelect = document.getElementById('quarter_select');
  //   const form = document.getElementById('progressForm');

  //   // Message div setup
  //   const messageDiv = document.createElement('div');
  //   messageDiv.id = 'quarterMessage';
  //   messageDiv.innerHTML = `
  //     <div class="card shadow-sm border-0 mx-auto" style="max-width: 450px;">
  //       <div class="card-body text-center py-5">
  //         <i class="fas fa-exclamation-circle text-warning mb-3" style="font-size: 2.5rem;"></i>
  //         <h5 class="fw-bold text-secondary mb-2">Please Select a Quarter</h5>
  //         <p class="text-muted mb-0">Choose a quarter from the dropdown above to display the form.</p>
  //       </div>
  //     </div>
  //   `;
  //   form.parentNode.insertBefore(messageDiv, form);
  //   form.style.display = 'none';

  //   quarterSelect.addEventListener('change', function () {
  //     const quarter = this.value;
  //     document.getElementById('quarter_hidden').value = quarter;

  //     if (!quarter) {
  //       form.style.display = 'none';
  //       messageDiv.style.display = 'block';
  //       Swal.fire({
  //         icon: 'warning',
  //         title: 'No Quarter Selected',
  //         text: 'Please select a quarter to view or edit data.',
  //       });
  //       return;
  //     }

  //     form.style.display = 'block';
  //     messageDiv.style.display = 'none';
  //     populateForm(quarter);
  //   });

  //   // Auto-load selected quarter (if any)
  //   const defaultQuarter = quarterSelect.value;
  //   if (defaultQuarter) {
  //     form.style.display = 'block';
  //     messageDiv.style.display = 'none';
  //     populateForm(defaultQuarter);
  //   }
  // });
  document.addEventListener('DOMContentLoaded', function () {
  const quarterSelect = document.getElementById('quarter_select');
  const form = document.getElementById('progressForm');

  // Message div setup
  const messageDiv = document.createElement('div');
  messageDiv.id = 'quarterMessage';
  messageDiv.innerHTML = `
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 450px;">
      <div class="card-body text-center py-5">
        <i class="fas fa-exclamation-circle text-warning mb-3" style="font-size: 2.5rem;"></i>
        <h5 class="fw-bold text-secondary mb-2">Please Select a Quarter</h5>
        <p class="text-muted mb-0">Choose a quarter from the dropdown above to display the form.</p>
      </div>
    </div>
  `;
  form.parentNode.insertBefore(messageDiv, form);
  form.style.display = 'none';

  // === Determine which quarters have data ===
  const availableQuarters = Object.keys(assessments)
    .filter(q => assessments[q] && Object.keys(assessments[q]).length > 0)
    .map(Number);

  console.log("Available Quarters:", availableQuarters);

  // === Control quarter visibility ===
  for (let i = 1; i <= 4; i++) {
    const option = quarterSelect.querySelector(`option[value="${i}"]`);
    if (option) {
      // Show first quarter or any quarter with data
      if (availableQuarters.includes(i) || (i === Math.max(...availableQuarters, 0) + 1)) {
        option.disabled = false;
      } else {
        option.disabled = true;
      }
    }
  }

  quarterSelect.addEventListener('change', function () {
    const quarter = this.value;
    document.getElementById('quarter_hidden').value = quarter;

    if (!quarter || quarterSelect.options[quarterSelect.selectedIndex].disabled) {
      form.style.display = 'none';
      messageDiv.style.display = 'block';
      Swal.fire({
        icon: 'warning',
        title: 'No Data',
        text: 'This quarter is not yet available.',
      });
      return;
    }

    form.style.display = 'block';
    messageDiv.style.display = 'none';
    populateForm(quarter);
  });

  // === Auto-load the first available quarter ===
  const defaultQuarter = availableQuarters[0];
  if (defaultQuarter) {
    quarterSelect.value = defaultQuarter;
    form.style.display = 'block';
    messageDiv.style.display = 'none';
    populateForm(defaultQuarter);
  } else {
    form.style.display = 'none';
    messageDiv.style.display = 'block';
  }
});


  // === Flash Messages ===
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
</script>


</body>
</html>
