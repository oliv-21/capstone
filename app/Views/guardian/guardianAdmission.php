<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Guardian Dashboard</title>
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
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <?php
  $isProfileIncomplete = empty($guardian->address) || empty($guardian->contact_number) || empty($guardian->occupation);
  ?>
  <div class="wrapper">
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
          <a href="<?= base_url('guardian/dashboard'); ?>" class="nav-link d-flex align-items-center active <?= !$hasChildren ? 'disabled-link' : '' ?>">
            <i class="fas fa-child me-4 fa-lg fa-fw text-secondary"></i>
            Admission
          </a>
          <a href=""
            class="nav-link d-flex align-items-center <?= !$hasChildren ? 'disabled-link' : '' ?>">
              <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i>
              <?php if ($unread_announcement > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $unread_announcement ?>
                </span>
              <?php endif; ?>
              Announcement
          </a>
 
          <a href=""
            class="nav-link d-flex align-items-center <?= !$hasChildren ? 'disabled-link' : '' ?>">
            <i class="fa-solid fa-money-bill me-4 fa-lg fa-fw text-secondary"></i>
            Payment
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
             <!-- Date -->



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
                 <img  src="<?= base_url('public/assets/profilepic/' . esc($students->profile_pic)) ?>"  alt="Profile Picture"
                    class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2"><?= esc($students->full_name) ?></span>
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

     <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto; background-color: #f8f9fa;">
        <div class="mb-3">
          <a href="<?= base_url('guardian/dashboard'); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-2"></i> Back
          </a>
        </div>

        <div class="container d-flex justify-content-center">
          <div class="card shadow-sm border-2 w-100" style="max-width: 1000px;">
            <div class="card-body p-4">

              <form id="admissionForm" method="post" action="<?= base_url(); ?>admissionpost" enctype="multipart/form-data" novalidate>

                <!-- SECTION: Student Info -->
                <div class="mb-4">
                  <h5 class="fw-bold text-primary mb-3">Student Information</h5>
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="firstname" name="first_name"
                            oninput="capitalizeFirstLetter(this)" required>
                      <div class="invalid-feedback">First Name is required.</div>
                    </div>

                    <div class="col-md-4">
                      <label for="middlename" class="form-label">Middle Name</label>
                      <input type="text" class="form-control" id="middlename" name="middle_name" placeholder="(optional)"
                            oninput="capitalizeFirstLetter(this)">
                    </div>

                    <div class="col-md-4">
                      <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="lastname" name="last_name"
                            oninput="capitalizeFirstLetter(this)" required>
                      <div class="invalid-feedback">Last Name is required.</div>
                    </div>
                  </div>

                  <div class="row g-3 mt-1">
                    <div class="col-md-6">
                      <label for="nickname" class="form-label">Nickname </label>
                      <input type="text" class="form-control" id="nickname" name="nickname"
                            oninput="capitalizeFirstLetter(this)" >
                      <div class="invalid-feedback">Nickname is required.</div>
                    </div>

                    <div class="col-md-6">
                      <label for="nationality" class="form-label">Nationality <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="nationality" name="nationality"
                            oninput="capitalizeFirstLetter(this)" required>
                      <div class="invalid-feedback">Nationality is required.</div>
                    </div>
                  </div>

                  <div class="row g-3 mt-1">
                    <div class="col-md-6">
                      <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                      <select class="form-select" id="gender" name="gender" required>
                        <option value="" selected disabled>Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                      </select>
                      <div class="invalid-feedback">Please select a Gender.</div>
                    </div>

                    <div class="col-md-6">
                      <label for="birthday" class="form-label">Birthday <span class="text-danger">*</span></label>
                      <input type="date" class="form-control" id="birthday" onchange="computeAge()" name="birthday" required>
                      <div class="invalid-feedback">Birthday is required.</div>
                    </div>
                  </div>

                  <div class="row g-3 mt-1">
                    <div class="col-md-6">
                      <label for="age" class="form-label">Age</label>
                      <input type="number" class="form-control bg-light" id="age" name="age" readonly>
                    </div>

                    <div class="col-md-6">
                      <label for="class" class="form-label">Class <span class="text-danger">*</span></label>
                      <select class="form-select" id="class" name="class_applied" required>
                        <option value="" selected disabled>Select a Class</option>
                        <?php foreach ($classes as $class): ?>
                          <option value="<?= esc($class['classname']) ?>"><?= esc($class['classname']) ?></option>
                        <?php endforeach; ?>
                      </select>
                      <div class="invalid-feedback">Class is required.</div>
                    </div>
                  </div>

                  <div class="row g-3 mt-2">
                    <div class="col-md-6">
                      <label for="picture1" class="form-label">2×2 Picture <span class="text-danger">*</span> </label>
                      <input type="file" class="form-control" id="picture1" name="picture" accept="image/*"  >
                    </div>

                    <div class="col-md-6">
                      <label for="psa" class="form-label">PSA <span class="text-danger">*</span></label>
                      <input type="file" class="form-control" id="psa" name="psa"
                            accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            required>
                      <div class="invalid-feedback">PSA is required.</div>
                    </div>
                  </div>
                </div>

                <!-- SECTION: Parents Info -->
                <div class="mb-4">
                  <h5 class="fw-bold text-primary mb-3">Parents Information</h5>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label for="fathername" class="form-label">Father's Name</label>
                      <input type="text" class="form-control" id="fathername" name="father_name"
                            oninput="capitalizeFirstLetter(this)">
                    </div>
                    <div class="col-md-6">
                      <label for="fatheroccupation" class="form-label">Father's Occupation</label>
                      <input type="text" class="form-control" placeholder="N/A" id="fatheroccupation" name="father_occupation"
                            oninput="capitalizeFirstLetter(this)">
                    </div>
                  </div>

                  <div class="row g-3 mt-1">
                    <div class="col-md-6">
                      <label for="mothername" class="form-label">Mother's Name</label>
                      <input type="text" class="form-control" id="mothername" name="mother_name"
                            oninput="capitalizeFirstLetter(this)" required>
                    </div>
                    <div class="col-md-6">
                      <label for="motheroccupation" class="form-label">Mother's Occupation</label>
                      <input type="text" placeholder="N/A" class="form-control" id="motheroccupation" name="mother_occupation"
                            oninput="capitalizeFirstLetter(this)">
                    </div>
                  </div>
                </div>

                <!-- SECTION: Contact Info -->
                <div class="mb-4">
                  <h5 class="fw-bold text-primary mb-3">Contact Information</h5>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label for="contactnumber" class="form-label">Contact Number <span class="text-danger">*</span></label>
                      <input type="tel" class="form-control" id="contactnumber" name="contact_number" required>
                      <div class="invalid-feedback">Contact number is required.</div>
                    </div>
                    <div class="col-md-6">
                      <label for="email" class="form-label">Email Address</label>
                      <input type="email" class="form-control" id="email" name="email">
                    </div>
                  </div>
                </div>

                <!-- SECTION: Address -->
                <div class="mb-4">
                  <h5 class="fw-bold text-primary mb-3">Address Information</h5>
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label">Municipality <span class="text-danger">*</span></label>
                      <select name="municipality" id="municipality" class="form-select" required>
                        <option value="">Select Municipality</option>
                      </select>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label">Barangay <span class="text-danger">*</span></label>
                      <select id="barangay" name="barangay" class="form-select" required>
                        <option value="">Select Barangay</option>
                      </select>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label">Street</label>
                      <input type="text" class="form-control" name="street" oninput="capitalizeFirstLetter(this)">
                    </div>
                  </div>
                </div>

                <!-- Submit -->
                <div class="text-end mt-5">
                  <button type="submit" id="applyBtn" class="btn btn-primary px-4">
                    <i class="fa-solid fa-paper-plane me-2"></i> Apply
                  </button>
                </div>

              </form>

            </div>
          </div>
        </div>
      </main>

    </div>
  </div>


  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>


  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/user.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const form = document.getElementById("admissionForm");
      const applyBtn = document.getElementById("applyBtn");
      const municipalitySelect = document.getElementById("municipality");
      const barangaySelect = document.getElementById("barangay");

      // Form submit handler
      applyBtn.addEventListener("click", function (e) {
        e.preventDefault();
        form.classList.add("was-validated");

        // Check required fields
        if (!form.checkValidity()) {
          Swal.fire({
            icon: "warning",
            title: "Incomplete Fields",
            text: "Please fill out all required fields correctly before submitting."
          });
          return;
        }

        // Confirm before submitting
        Swal.fire({
          title: "Confirm Application?",
          text: "Please review your information before submitting.",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Submit"
        }).then((result) => {
          if (result.isConfirmed) {
            applyBtn.disabled = true; // prevent double submit
            form.submit();
          }
        });
      });

      // Load municipalities
      fetch("https://psgc.gitlab.io/api/provinces/043400000/municipalities")
        .then(response => response.json())
        .then(data => {
          municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
          data.forEach(muni => {
            const option = document.createElement("option");
            option.value = muni.name;
            option.textContent = muni.name;
            municipalitySelect.appendChild(option);
          });
        })
        .catch(() => {
          Swal.fire("Error", "Failed to load municipalities.", "error");
        });

      // Load barangays when municipality changes
      municipalitySelect.addEventListener("change", function () {
        const selectedName = this.value;
        fetch("https://psgc.gitlab.io/api/provinces/043400000/municipalities")
          .then(response => response.json())
          .then(data => {
            const selectedMunicipality = data.find(m => m.name === selectedName);
            const code = selectedMunicipality?.code;
            if (!code) return;

            barangaySelect.innerHTML = '<option value="">Loading barangays...</option>';
            fetch(`https://psgc.gitlab.io/api/cities-municipalities/${code}/barangays`)
              .then(response => response.json())
              .then(data => {
                barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                data.forEach(brgy => {
                  const option = document.createElement("option");
                  option.value = brgy.name;
                  option.textContent = brgy.name;
                  barangaySelect.appendChild(option);
                });
              });
          });
      });
    });

    // Capitalize function
    function capitalizeFirstLetter(input) {
      input.value = input.value
        .toLowerCase()
        .replace(/\b\w/g, char => char.toUpperCase());
    }
  </script>


</body>

</html>