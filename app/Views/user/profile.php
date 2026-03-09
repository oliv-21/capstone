<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Profile</title>
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
  <link rel="stylesheet" href="assets/css/user.css">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 min-vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img src="assets/img/logoicon.png" alt="Logo" class="me-3 ms-1" style="width: 38px;">
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
        <div class="container-fluid d-flex justify-content-between">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>
          <div class="text-primary m-0 ms-3 d-none d-md-block">
            <h5 class="text-primary m-0 ms-3 ">Profile</h5>
          </div>

          <div class="d-flex align-items-center ms-auto py-1">
            <a href="#" class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-bell fa-lg fa-fw" ></i>
            </a>

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img  src="<?= base_url('public/assets/profilepic/' . esc($studentprofile->profile_pic)) ?>"  alt="Profile Picture"
                    class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2"><?= esc($student->full_name) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('student-profile'); ?>"><i class='fa-solid fa-user me-3 mb-2 text-primary mt-2'></i>Profile</a></li>
                <li><hr class="dropdown-divider"></li>
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
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-11">

              <form id="profileForm" method="post" action="<?= base_url(); ?>update_profilepost" enctype="multipart/form-data">

                <!-- Profile Picture Card -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                  <div class="card-header bg-primary text-white rounded-top-2">
                    <h5 class="mb-0"><i class="fa-solid fa-image me-2"></i> Profile Picture</h5>
                  </div>
                  <div class="card-body">
                      <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <img src="<?= base_url('public/assets/profilepic/' . esc($studentprofile->profile_pic)) ?>"    alt="Profile Picture" class="rounded border" width="120" height="120">
                        </div>
                        <div class="col">
                          <label for="profileImage" class="form-label fw-bold">Upload New Profile Picture</label>
                          <input type="file" class="form-control form-control-sm" name="profile_pic" id="profileImage" accept="image/*">
                        </div>
                      </div>
                  </div>
                </div>

                <!-- Student Information Card -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                  <div class="card-header bg-primary text-white rounded-top-2">
                    <h5 class="mb-0"><i class="fa-solid fa-user-graduate me-2"></i> Student Information</h5>
                  </div>
                  <div class="card-body">
                    <input type="hidden" name="user_id" value="<?= esc($studentprofile->user_id) ?>">
                    <input type="hidden" name="admission_id" value="<?= esc($studentprofile->admission_id) ?>">
                    <div class="row g-3">
                      <div class="col-md-4">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control form-control-sm" name="first_name" value="<?= esc($studentprofile->first_name) ?>" readonly>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input type="text" class="form-control form-control-sm" name="middle_name" value="<?= esc($studentprofile->middle_name) ?>" readonly>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control form-control-sm" name="last_name" value="<?= esc($studentprofile->last_name) ?>" readonly>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Nickname</label>
                        <input type="text" class="form-control form-control-sm" name="nickname" value="<?= esc($studentprofile->nickname) ?>">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Nationality</label>
                        <input type="text" class="form-control form-control-sm" name="nationality" value="<?= esc($studentprofile->nationality) ?>" readonly>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select class="form-select form-select-sm" name="gender">
                          <option>Select Gender</option>
                          <option value="male" <?= $studentprofile->gender == 'male' ? 'selected' : '' ?>>Male</option>
                          <option value="female" <?= $studentprofile->gender == 'female' ? 'selected' : '' ?>>Female</option>
                          <option value="other" <?= $studentprofile->gender == 'other' ? 'selected' : '' ?>>Other</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Birthday</label>
                        <input type="date" class="form-control form-control-sm" id="birthday" name="birthday" onchange="computeAge()" value="<?= esc($studentprofile->admission_birthday) ?>">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Age</label>
                        <input type="number" class="form-control form-control-sm" id="age" name="age" readonly value="<?= esc($studentprofile->age) ?>">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Class</label>
                        <input type="text" class="form-control form-control-sm" name="class_level" value="<?= esc($studentprofile->class_level) ?>" readonly>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Parent Information Card -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                  <div class="card-header bg-primary text-white rounded-top-2">
                    <h5 class="mb-0"><i class="fa-solid fa-users me-2"></i> Parent Information</h5>
                  </div>
                  <div class="card-body">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label">Father's Name</label>
                        <input type="text" class="form-control form-control-sm" name="father_name" value="<?= esc($studentprofile->father_name) ?>">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Father's Occupation</label>
                        <input type="text" class="form-control form-control-sm" name="father_occupation" value="<?= esc($studentprofile->father_occupation) ?>">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Mother's Name</label>
                        <input type="text" class="form-control form-control-sm" name="mother_name" value="<?= esc($studentprofile->mother_name) ?>">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Mother's Occupation</label>
                        <input type="text" class="form-control form-control-sm" name="mother_occupation" value="<?= esc($studentprofile->mother_occupation) ?>">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Contact Information Card -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                  <div class="card-header bg-primary text-white rounded-top-2">
                    <h5 class="mb-0"><i class="fa-solid fa-address-book me-2"></i> Contact Information</h5>
                  </div>
                  <div class="card-body">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label">Contact Number</label>
                        <input type="text" class="form-control form-control-sm" name="contact_number" value="<?= esc($studentprofile->contact_number) ?>">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control form-control-sm" name="email" value="<?= esc($studentprofile->email) ?>">
                      </div>
                      <div class="col-xl-4">
                        <label for="" class="form-label">Municipality</label>
                        <input type="text" class="form-control" id="" name ="municipality" value="<?= esc($studentprofile->municipality) ?>"    oninput="capitalizeFirstLetter(this)">
                      </div>
                      <div class="col-lg-4">
                        <label for="" class="form-label">Barangay</label>
                        <input type="text" class="form-control" id="" name = "barangay" value="<?= esc($studentprofile->barangay) ?>"  oninput="capitalizeFirstLetter(this)">
                      </div>
                      <div class="col-md-4">
                        <label for="" class="form-label">Street</label>
                        <input type="text" class="form-control" id="" name="street" value="<?= esc($studentprofile->street) ?>" oninput="capitalizeFirstLetter(this)">
                      </div>

                    </div>
                  </div>
                </div>

                <!-- Submit Button -->
                <div class="text-end">
                  <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-save me-2"></i> Save Changes
                  </button>
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
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/user.js"></script>
  <!-- SweetAlert2 CSS & JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
  document.getElementById('profileForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Stop default submission

      Swal.fire({
          title: 'Are you sure?',
          text: "Do you want to save these changes?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, save it!',
          cancelButtonText: 'Cancel'
      }).then((result) => {
          if (result.isConfirmed) {
              this.submit(); // Submit form if confirmed
          }
      });
  });
  </script>

</body>

</html>