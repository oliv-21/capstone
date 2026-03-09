<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css">
  <link href="assets/img/logoicon.png" rel="icon" />

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img src="assets/img/logoicon.png" alt="Logo" class="me-3 ms-1" style="width: 38px;">
        <span class="text-primary fw-bold fs-3">Brightside</span>
      </div>
      <div class="d-flex flex-column align-items-start">
        <hr class="mb-2" />
        <a href="<?= base_url(); ?>teacher-dashboard" class="nav-link d-flex align-items-center">
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
        <a href="<?= base_url(); ?>teacher-annoucement" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-bell me-4 fa-lg fa-fw text-secondary"></i> Announcements
        </a>
        <a href="<?= base_url(); ?>teacher-interactive-learning" class="nav-link d-flex align-items-center">
          <i class="fas fa-layer-group me-4 fa-lg fa-fw text-secondary"></i> Interactive Learning
        </a>
      </div>
    </nav>

    <!-- Main -->
    <div class="main col-md-10">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
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

            <!-- Profile Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($profilepic)) ?>" alt="Profile Image"
                  class="me-2 rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                <span class="fw-bold ms-2"><?= esc($teacher->fullname) ?></span>
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

      <!-- Content -->
      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-11">

              <!-- Unified Profile Card -->
              <form id="updateProfileForm" method="post"
                action="<?= base_url(); ?>update_profilepost-teacher"
                enctype="multipart/form-data">

                <div class="card shadow-sm border-0 rounded-4 mb-4">
                  <div class="card-header bg-primary text-white rounded-top-2">
                    <h5 class="mb-0"><i class="fa-solid fa-user me-2"></i> Teacher Profile</h5>
                  </div>

                  <div class="card-body">
                    <input type="hidden" name="user_id" value="<?= esc($teacher->user_id) ?>">
                    <input type="hidden" name="admission_id" value="<?= esc($teacher->id) ?>">
                    <input type="hidden"  name="profilePic"
                          value="<?= esc($teacher->profile_pic) ?>" >

                    <!-- Profile Picture -->
                    <div class="mb-4 text-center">
                      <label class="form-label fw-semibold d-block">Profile Picture</label>
                      <?php if (!empty($profilepic)) : ?>
                        <img id="profilePreview"
                          src="<?= base_url('public/assets/profilepic/' . $profilepic) ?>"
                          alt="Profile Picture"
                          width="120" height="120"
                          class="rounded-circle border mb-2"
                          style="object-fit: cover;">
                      <?php endif; ?>
                      <input type="file" name="profile_image" id="profileInput" class="w-50 form-control form-control-sm mx-auto"
                        accept="image/*">
                    </div>

                    <!-- Personal Information -->
                    <h6 class="text-primary fw-bold mb-3 border-bottom pb-1"><i class="fa-solid fa-id-card me-2"></i>Personal Information</h6>
                    <div class="row g-3 mb-3">
                      <div class="col-md-4">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control form-control-sm" name="first_name"
                          value="<?= esc($teacher->first_name) ?>" required>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input type="text" class="form-control form-control-sm" name="middle_name"
                          value="<?= esc($teacher->middle_name) ?>">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control form-control-sm" name="last_name"
                          value="<?= esc($teacher->last_name) ?>" required>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" class="form-control form-control-sm" name="date_of_birth"
                          value="<?= esc($teacher->birthday ?? '') ?>" required>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Gender</label>
                        <select class="form-select form-select-sm" name="gender" required>
                          <option value="" disabled <?= empty($teacher->gender) ? 'selected' : '' ?>>Select Gender</option>
                          <option value="Male" <?= (isset($teacher->gender) && $teacher->gender == 'Male') ? 'selected' : '' ?>>Male</option>
                          <option value="Female" <?= (isset($teacher->gender) && $teacher->gender == 'Female') ? 'selected' : '' ?>>Female</option>
                          <option value="Other" <?= (isset($teacher->gender) && $teacher->gender == 'Other') ? 'selected' : '' ?>>Other</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Civil Status</label>
                        <select class="form-select form-select-sm" name="civil_status" required>
                          <option value="" disabled <?= empty($teacher->civil_status) ? 'selected' : '' ?>>Select Status</option>
                          <option value="Single" <?= (isset($teacher->civil_status) && $teacher->civil_status == 'Single') ? 'selected' : '' ?>>Single</option>
                          <option value="Married" <?= (isset($teacher->civil_status) && $teacher->civil_status == 'Married') ? 'selected' : '' ?>>Married</option>
                          <option value="Widowed" <?= (isset($teacher->civil_status) && $teacher->civil_status == 'Widowed') ? 'selected' : '' ?>>Widowed</option>
                          <option value="Separated" <?= (isset($teacher->civil_status) && $teacher->civil_status == 'Separated') ? 'selected' : '' ?>>Separated</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                          <label class="form-label">Municipality</label>
                          <select id="municipality" name="municipality" class="form-control form-control-sm" required>
                            <option value="<?= esc($teacher->municipality) ?>" selected>
                              <?= esc($teacher->municipality) ?: 'Select Municipality' ?>
                            </option>
                          </select>
                        </div>
                     <div class="col-md-4">
                        <label class="form-label">Barangay</label>
                        <select id="barangay" name="barangay" class="form-control form-control-sm" required>
                          <option value="<?= esc($teacher->barangay) ?>" selected>
                            <?= esc($teacher->barangay) ?: 'Select Barangay' ?>
                          </option>
                        </select>
                      </div>
                       <div class="col-md-4">
                        <label class="form-label">Street</label>
                        <input type="text" class="form-control form-control-sm"  name="street" value="<?= esc($teacher->street) ?>" oninput="capitalizeFirstLetter(this)">
                      </div>
                    </div>

                    <!-- Contact Information -->
                    <h6 class="text-primary fw-bold mb-3 border-bottom pb-1"><i class="fa-solid fa-phone me-2"></i>Contact Information</h6>
                    <div class="row g-3 mb-3">
                      <div class="col-md-6">
                        <label class="form-label">Contact Number</label>
                        <input type="tel" class="form-control form-control-sm" name="contact_number"
                          value="<?= esc($teacher->contact_number) ?>" 
                           maxlength="11"
                          oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                           required>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control form-control-sm" name="email"
                          value="<?= esc($teacher->email) ?>" required>
                      </div>
                    </div>

                    <!-- Professional Information -->
                    <h6 class="text-primary fw-bold mb-3 border-bottom pb-1"><i class="fa-solid fa-user-tie me-2"></i>Professional Information</h6>
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label">Specialization</label>
                        <input type="text" class="form-control form-control-sm" name="specialization"
                          value="<?= esc($teacher->specialization) ?>" required>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Department</label>
                        <input type="text" class="form-control form-control-sm" name="teacher_department"
                          value="<?= esc($teacher->teacher_department) ?>" required>
                      </div>
                    </div>

                  </div>

                  <div class="card-footer text-end bg-light border-top-0">
                    <button type="submit" class="btn btn-success px-4">
                      <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                    </button>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="dist/js/bootstrap.bundle.min.js"></script>

  <!-- SweetAlert2 Confirmation -->
  <script>
   document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById('updateProfileForm');
  const email = document.querySelector('input[name="email"]');
  const contact = document.querySelector('input[name="contact_number"]');

  form.addEventListener('submit', function(e) {
    e.preventDefault();

    // ✅ Email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email.value.trim() && !emailPattern.test(email.value.trim())) {
      email.classList.add('is-invalid');
      Swal.fire({
        icon: 'error',
        title: 'Invalid Email',
        text: 'Please enter a valid email address.',
        confirmButtonColor: '#3085d6'
      });
      return;
    } else {
      email.classList.remove('is-invalid');
    }

    // ✅ Contact number validation (must start with 09 and be 11 digits)
    if (contact.value.trim() && !/^09[0-9]{9}$/.test(contact.value.trim())) {
      contact.classList.add('is-invalid');
      Swal.fire({
        icon: 'error',
        title: 'Invalid Contact Number',
        text: 'Contact number must start with 09 and be 11 digits long.',
        confirmButtonColor: '#3085d6'
      });
      return;
    } else {
      contact.classList.remove('is-invalid');
    }

    // ✅ Confirmation dialog
    Swal.fire({
      title: 'Save Changes?',
      text: "Do you want to update your profile information?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, Save',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#6c757d'
    }).then(result => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
});


    document.addEventListener("DOMContentLoaded", function () {
  const municipalitySelect = document.getElementById("municipality");
  const barangaySelect = document.getElementById("barangay");
  const currentMuni = municipalitySelect.value;
  const currentBrgy = barangaySelect.value;

  fetch("https://psgc.gitlab.io/api/provinces/043400000/municipalities")
    .then(res => res.json())
    .then(data => {
      municipalitySelect.innerHTML = `<option value="${currentMuni}" selected>${currentMuni || 'Select Municipality'}</option>`;
      data.forEach(muni => {
        if (muni.name !== currentMuni) {
          const opt = document.createElement("option");
          opt.value = muni.name;
          opt.textContent = muni.name;
          municipalitySelect.appendChild(opt);
        }
      });
    });

  // Load barangays for the current municipality on page load
  if (currentMuni) {
    fetch(`https://psgc.gitlab.io/api/provinces/043400000/municipalities`)
      .then(res => res.json())
      .then(data => {
        const muni = data.find(m => m.name === currentMuni);
        const code = muni?.code;
        if (!code) return;

        fetch(`https://psgc.gitlab.io/api/cities-municipalities/${code}/barangays`)
          .then(res => res.json())
          .then(data => {
            barangaySelect.innerHTML = `<option value="${currentBrgy}" selected>${currentBrgy || 'Select Barangay'}</option>`;
            data.forEach(brgy => {
              if (brgy.name !== currentBrgy) {
                const opt = document.createElement("option");
                opt.value = brgy.name;
                opt.textContent = brgy.name;
                barangaySelect.appendChild(opt);
              }
            });
          });
      });
  }

  // Change municipality → load barangays
  municipalitySelect.addEventListener("change", function () {
    const selected = this.value;
    fetch("https://psgc.gitlab.io/api/provinces/043400000/municipalities")
      .then(res => res.json())
      .then(data => {
        const muni = data.find(m => m.name === selected);
        const code = muni?.code;
        if (!code) return;

        barangaySelect.innerHTML = '<option>Loading barangays...</option>';
        fetch(`https://psgc.gitlab.io/api/cities-municipalities/${code}/barangays`)
          .then(res => res.json())
          .then(data => {
            barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
            data.forEach(brgy => {
              const opt = document.createElement("option");
              opt.value = brgy.name;
              opt.textContent = brgy.name;
              barangaySelect.appendChild(opt);
            });
          });
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
    
  </script>
</body>

</html>
