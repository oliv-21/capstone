<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Edit Student | Brightside</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css'); ?>">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css'); ?>">

  <style>
    body {
      background-color: #f8f9fc;
      font-family: 'Nunito', sans-serif;
      overflow-y: auto;
      /* enable vertical scroll */
    }

    .container {
      max-height: 90vh;
      /* limit container height to viewport */
      overflow-y: auto;
      /* make container scrollable */
      padding-right: 10px;
      /* prevent scrollbar overlap */
    }

    .card {
      border-radius: 15px;
    }

    label {
      font-weight: 600;
      color: #555;
    }
  </style>

</head>

<body>
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
          <a href="<?= base_url('guardian/dashboard'); ?>" class="nav-link d-flex align-items-center active ">
            <i class="fas fa-child me-4 fa-lg fa-fw text-secondary"></i>
            Admission
          </a>
          <a href="<?= base_url('/guardian-announcement/' . esc($students->user_id)); ?>"
            class="nav-link d-flex align-items-center <?= !$hasChildren ? 'disabled-link' : '' ?>">
              <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i>
              <?php if ($unread_announcement > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $unread_announcement ?>
                </span>
              <?php endif; ?>
              Announcement
          </a>
 
          <a href="<?= base_url('/payment-history/' . esc($students->user_id)); ?> "
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
                <img src="<?= base_url('public/assets/profilepic/' . esc($students->profile_pic)) ?>"
                  alt="Profile Picture" class="rounded-circle border border-2" width="30" height="30">
                   <span class="fw-bold ms-2"><?= esc($students->full_name) ?></span>
                <span class="fw-bold ms-2"></span>
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
        <a href="<?= base_url('Studentview/' . $student->admission_id); ?>" class="btn btn-outline-secondary btn-sm mb-3">
          <i class="fa-solid fa-arrow-left me-2"></i>Back
        </a>
        <div class="text-center mb-4">
          <h4 class="text-primary fw-bold">Edit Student Profile</h4>
          <p class="text-muted">Update student information and documents</p>
        </div>

        <div class="card shadow-sm border-2 mx-auto" style="max-width: 1000px;">
          <div class="card-body p-4">

            <form action="<?= base_url('guardian/update-student/' . $student->admission_id) ?>" id="editProfileForm"
              method="post" enctype="multipart/form-data">
              <?= csrf_field() ?>

              <!-- Basic Info -->
              <h5 class="text-primary fw-bold mb-3">Children Information</h5>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="first_name" class="form-label">First Name</label>
                  <input type="text" class="form-control" id="first_name" name="first_name"
                    value="<?= esc($student->first_name ?? '') ?>">
                </div>
                <div class="col-md-6">
                  <label for="middle_name" class="form-label">Middle Name</label>
                  <input type="text" class="form-control" id="middle_name" name="middle_name"
                    value="<?= esc($student->middle_name ?? '') ?>">
                </div>
                <div class="col-md-6">
                  <label for="last_name" class="form-label">Last Name </label>
                  <input type="text" class="form-control" id="last_name" name="last_name"
                    value="<?= esc($student->last_name ?? '') ?>">
                </div>
                <div class="col-md-6">
                  <label for="nickname" class="form-label">Nickname</label>
                  <input type="text" class="form-control" id="nickname" name="nickname"
                    value="<?= esc($student->nickname ?? '') ?>">
                </div>
                <div class="col-md-6">
                  <label for="birthday" class="form-label">Birthdate</label>
                  <input type="date" class="form-control" id="birthday" oninput="computeAge()" name="birthday"
                    value="<?= esc($student->birthday ?? '') ?>">
                </div>
                <div class="col-md-6">
                  <label for="age" class="form-label">Age</label>
                  <input type="number" class="form-control" id="age" name="age" value="<?= esc($student->age ?? '') ?>">
                </div>

              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="gender" class="form-label">Gender</label>
                  <input type="text" class="form-control" id="gender" name="gender"
                    value="<?= esc($student->gender ?? '') ?>">
                </div>
                <div class="col-md-6">
                  <label for="nationality" class="form-label">Nationality</label>
                  <input type="text" class="form-control" id="nationality" name="nationality"
                    value="<?= esc($student->nationality ?? '') ?>">
                </div>
              </div>

              <div class="row mb-3">

                <div class="col-md-6">
                  <label for="contact_number" class="form-label">Contact Number</label>
                  <input type="text" class="form-control" id="contact_number" name="contact_number"
                    value="<?= esc($student->contact_number ?? '') ?>">
                </div>
                <div class="col-md-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" value="<?= esc($student->email ?? '') ?>"
                    readonly>
                </div>

              </div>

              <!-- Address Section -->
              <h5 class="text-primary fw-bold mb-3 mt-4">Address</h5>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="municipality" class="form-label">Municipality</label>
                  <select name="municipality" id="municipality" class="form-control" required>
                    <option value="">Select Municipality</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="barangay" class="form-label">Barangay</label>
                  <select id="barangay" name="barangay" class="form-control" required>
                    <option value="">Select Barangay</option>
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label for="street" class="form-label">Street</label>
                <input type="text" class="form-control" id="street" name="street" value="<?= esc($student->street ?? '') ?>"
                  oninput="capitalizeFirstLetter(this)">
              </div>



              <!-- File Uploads -->
              <div class="row mb-4">
                <!-- 2x2 Picture -->
                <div class="col-md-6">
                  <label for="picture" class="form-label">2×2 Picture</label>

                  <?php if (!empty($student->picture)): ?>
                  <div class="mb-2">
                    <small class="text-muted d-block">Current:</small>
                    <img src="<?= base_url('public/assets/profilepic/' . esc($student->picture)) ?>" alt="Current Picture"
                      width="100" class="img-thumbnail">
                  </div>
                  <?php endif; ?>

                  <input type="file" class="form-control" id="picture" name="picture" accept="image/*">
                </div>

                <!-- PSA -->
                <div class="col-md-6">
                  <label for="psa" class="form-label">PSA</label>

                  <?php if (!empty($student->psa)): ?>
                  <div class="mb-2">
                    <small class="text-muted d-block">Current:</small>
                    <?php 
                                  $ext = pathinfo($student->psa, PATHINFO_EXTENSION);
                                  if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])): ?>
                    <img src="<?= base_url('public/assets/psa/' . esc($student->psa)) ?>" alt="Current PSA" width="100"
                      class="img-thumbnail">
                    <?php else: ?>
                    <a href="<?= base_url('public/assets/psa/' . esc($student->psa)) ?>" target="_blank">
                      <?= esc($student->psa) ?>
                    </a>
                    <?php endif; ?>
                  </div>
                  <?php endif; ?>

                  <input type="file" class="form-control" id="psa" name="psa"
                    accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                </div>
              </div>


              <!-- Parent Info -->
              <h5 class="text-primary fw-bold mb-3 mt-4">Parent Information</h5>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="father_name" class="form-label">Father's Name</label>
                  <input type="text" class="form-control" id="father_name" name="father_name"
                    value="<?= esc($student->father_name ?? '') ?>">
                </div>
                <div class="col-md-6">
                  <label for="mother_name" class="form-label">Mother's Name</label>
                  <input type="text" class="form-control" id="mother_name" name="mother_name"
                    value="<?= esc($student->mother_name ?? '') ?>">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="father_occupation" class="form-label">Father's Occupation</label>
                  <input type="text" class="form-control" id="father_occupation" name="father_occupation"
                    value="<?= esc($student->father_occupation ?? '') ?>">
                </div>
                <div class="col-md-6">
                  <label for="mother_occupation" class="form-label">Mother's Occupation</label>
                  <input type="text" class="form-control" id="mother_occupation" name="mother_occupation"
                    value="<?= esc($student->mother_occupation ?? '') ?>">
                </div>
              </div>

              <!-- Class Info -->
              <h5 class="text-primary fw-bold mb-3 mt-4">Class Information</h5>
              <div class="row mb-4">
                <!-- <div class="col-md-6">
                  <label for="admission_id" class="form-label">Admission ID</label>
                  <input type="text" class="form-control" id="admission_id" name="admission_id" value="<?= esc($student->admission_id ?? '') ?>" readonly>
                </div> -->
                <div class="col-md-6">
                  <label for="class_applied" class="form-label">Class Applied</label>
                  <select name="class_applied" id="class_applied" class="form-control" required>
                    <?php if (!empty($student->class_applied)): ?>
                    <option value="<?= esc($student->class_applied) ?>" selected>
                      <?= esc($student->class_applied) ?>
                    </option>
                    <?php else: ?>
                    <option value="" selected disabled>Select a Class</option>
                    <?php endif; ?>

                    <?php foreach ($classes as $class): ?>
                    <?php if ($class['classname'] !== ($student->class_applied ?? '')): ?>
                    <option value="<?= esc($class['classname']) ?>">
                      <?= esc($class['classname']) ?>
                    </option>
                    <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </div>


              </div>

              <!-- Buttons -->
              <div class="text-end">
                <button type="submit" id="editProfileBtn" class="btn btn-primary me-2">
                  <i class="fa-solid fa-floppy-disk me-1"></i>Save Changes
                </button>

              </div>
            </form>

          </div>
        </div>
      </main>
      
    </div>

    <script src="<?= base_url('dist/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="assets/js/user.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const municipalitySelect = document.getElementById("municipality");
        const barangaySelect = document.getElementById("barangay");

        const currentMunicipality = "<?= esc($student->municipality ?? '') ?>";
        const currentBarangay = "<?= esc($student->barangay ?? '') ?>";

        fetch("https://psgc.gitlab.io/api/provinces/043400000/municipalities")
          .then(response => response.json())
          .then(data => {
            municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
            data.forEach(muni => {
              const option = document.createElement("option");
              option.value = muni.name;
              option.textContent = muni.name;
              if (muni.name === currentMunicipality) option.selected = true;
              municipalitySelect.appendChild(option);
            });

            if (currentMunicipality) loadBarangays(currentMunicipality, currentBarangay);
          });

        municipalitySelect.addEventListener("change", function () {
          loadBarangays(this.value, null);
        });

        function loadBarangays(selectedName, preselectBarangay) {
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
                    if (brgy.name === preselectBarangay) option.selected = true;
                    barangaySelect.appendChild(option);
                  });
                });
            });
        }
      });


      document.getElementById("editProfileBtn").addEventListener("click", function (e) {
        e.preventDefault();

        const form = document.getElementById("editProfileForm"); // make sure your form has this id

        Swal.fire({
          title: "Are you sure?",
          text: "Please review your changes before updating your profile.",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Update Profile"
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });

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

    function computeAge() {
  const birthDate = new Date(document.getElementById('birthday').value);
  if (isNaN(birthDate)) return;
  const today = new Date();
  let age = today.getFullYear() - birthDate.getFullYear();
  const m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  document.getElementById('age').value = age;
}


    </script>
  </div>
</body>

</html>