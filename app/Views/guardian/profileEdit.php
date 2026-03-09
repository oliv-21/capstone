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
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="assets/img/logoicon.png" rel="icon" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css') ?>">

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
          
          <a href="<?= base_url('guardian/dashboard'); ?>" class="nav-link d-flex align-items-center  ">
            <i class="fas fa-child me-4 fa-lg fa-fw text-secondary"></i>
            Admission
          </a>

          <a href="<?= base_url('/guardian-announcement/'. esc($students->user_id)); ?>" class="nav-link d-flex align-items-center <?= !$hasChildren ? 'disabled-link' : '' ?> ">
            <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i>
           
            Announcement
          </a>

          <a href="<?= base_url('/payment-history/'. esc($students->user_id)); ?>" class="nav-link d-flex align-items-center <?= !$hasChildren ? 'disabled-link' : '' ?> ">
            <i class="fa-solid fa-money-bill me-4 fa-lg fa-fw text-secondary"></i> Payment
          </a>
        </div>
      </div>

      <!-- Children section -->
      <div class="mt-5">
        <hr>
        <span class="fw-bold text-secondary small ms-1">Children</span>
        <ul class="list-unstyled ms-1 mt-2">
          <?php if (!empty($childrens)): ?>
            <?php foreach ($childrens as $child): ?>
            <li class="dropdown-item-text d-flex align-items-center mt-2">
              <a href="<?= base_url('/StudentviewDashboard/' . $child->admission_id) ?>"
                class="d-flex align-items-center text-decoration-none">
                <img src="<?= base_url('public/assets/profilepic/' . esc($child->profile_pic)) ?>"
                  alt="Child" class="rounded-circle border border-2 me-2" width="25" height="25">
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

    <!-- Main Content -->
    <div class="main col-md-10">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle"><i class="fas fa-bars"></i></button>
          <h5 class="text-primary m-0 ms-3 d-none d-md-block">Profile</h5>

          <div class="d-flex align-items-center ms-auto py-1">
            <div class="dropdown me-3 position-relative border-start border-2 ps-3">
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false"
                onclick="markAsRead(<?= esc($students->user_id) ?>)">
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                <span id="notifBadge"
                  class="position-absolute top-0 start-100 translate-middle">

                </span>

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
            <div class="dropdown border-start border-2 ps-4">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($guardian->profile_pic)) ?>" alt="Profile Picture"
                class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2"><?= esc($guardian->full_name) ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('guardian-Profile'); ?>"><i class='fa-solid fa-user me-3 mb-2 text-primary mt-2'></i>Profile</a></li>
                <li><a class="dropdown-item" href="<?= base_url('guardian-resetPassword'); ?>"><i class='fa-solid fa-key me-3 mb-2 text-primary mt-2'></i>Reset Password</a></li>
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

            <!-- Form -->
      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-11">
              <div class="card shadow-sm border-0 rounded-4 mb-4">
                
                <!-- Header -->
                <div class="card-header bg-primary text-white rounded-top-2">
                  <h5 class="mb-0"><i class="fa-solid fa-user-edit mb-0"></i> Edit Guardian Profile</h5>
                </div>

                <div class="card-body p-4">
                  <form method="post" action="<?= base_url(); ?>gardian-update-profilepost" enctype="multipart/form-data">

                    <!-- Profile Picture -->
                    <div class="text-center mb-5">
                      <img src="<?= base_url('public/assets/profilepic/' . esc($studentprofile->profile_pic)) ?>" 
                          alt="Profile Picture" class="rounded-circle border border-3 mb-3" width="120" height="120">
                      <div class="col-md-6 mx-auto">
        
                        <input type="file" class="form-control form-control-sm" name="profile_pic" accept="image/*">
                      </div>
                    </div>

                    <input type="hidden" name="user_id" value="<?= esc($studentprofile->user_id) ?>">

                    <!-- Guardian Information -->
                    <h6 class="text-primary fw-bold mb-3 border-bottom pb-1">Personal Information</h6>
                    <div class="row g-3">
                      <div class="col-md-4">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control form-control-sm" name="first_name" value="<?= esc($studentprofile->first_name) ?>" oninput="capitalizeFirstLetter(this)" required>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input type="text" class="form-control form-control-sm" 
                          name="middle_name" 
                          value="<?= esc(trim($studentprofile->middle_name) ?: '') ?>" 
                          oninput="capitalizeFirstLetter(this)"
                          placeholder="N/A">
                          

                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control form-control-sm" name="last_name" value="<?= esc($studentprofile->last_name) ?>" oninput="capitalizeFirstLetter(this)" required >
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Relationship</label>
                        <select name="relationship" class="form-control form-control-sm">
                          <option value="">-- Select Relationship --</option>
                          <option value="Mother" <?= ($studentprofile->relationship == 'Mother') ? 'selected' : '' ?>>Mother</option>
                          <option value="Father" <?= ($studentprofile->relationship == 'Father') ? 'selected' : '' ?>>Father</option>
                          <option value="Guardian" <?= ($studentprofile->relationship == 'Guardian') ? 'selected' : '' ?>>Guardian</option>
                          <option value="Sibling" <?= ($studentprofile->relationship == 'Sibling') ? 'selected' : '' ?>>Sibling</option>
                          <option value="Other" <?= ($studentprofile->relationship == 'Other') ? 'selected' : '' ?>>Other</option>
                        </select>
                      </div>

                      

                      <div class="col-md-4">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control form-control-sm" name="username" value="<?= esc(trim($studentprofile->username ?? '')) ?>"  placeholder="N/A" >
                      </div>
                     
                    </div>
                    
                    <!-- contact Information -->
                    <h6 class="text-primary fw-bold mt-4 mb-3 border-bottom pb-1">Contact Information</h6>
                    <div class="row g-3">
                      <div class="col-md-4">
                        <label class="form-label">Contact Number</label>
                        <input type="text" class="form-control form-control-sm" name="contact_number" value="<?= esc($studentprofile->contact_number) ?>"
                           maxlength="11"
                          oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control form-control-sm" name="email" value="<?= esc($studentprofile->email) ?>">
                      </div>
                    </div>

                    <!-- Address Information -->
                    <h6 class="text-primary fw-bold mt-4 mb-3 border-bottom pb-1">Address Information</h6>
                    <div class="row g-3">
                      <div class="col-md-4">
                          <label class="form-label">Municipality</label>
                          <select id="municipality" name="municipality" class="form-control form-control-sm" required>
                            <option value="<?= esc($studentprofile->municipality) ?>" selected>
                              <?= esc($studentprofile->municipality) ?: 'Select Municipality' ?>
                            </option>
                          </select>
                        </div>

                      <div class="col-md-4">
                        <label class="form-label">Barangay</label>
                        <select id="barangay" name="barangay" class="form-control form-control-sm" required>
                          <option value="<?= esc($studentprofile->barangay) ?>" selected>
                            <?= esc($studentprofile->barangay) ?: 'Select Barangay' ?>
                          </option>
                        </select>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Street</label>
                        <input type="text" class="form-control form-control-sm"  name="street" value="<?= esc($studentprofile->street) ?>" oninput="capitalizeFirstLetter(this)">
                      </div>
                    </div>

                    <!-- Save Button -->
                    <div class="card-footer bg-transparent border-0 text-end mt-4">
                      <button type="submit" class="btn btn-success px-4">
                        <i class="fa-solid fa-save me-2"></i> Save Changes
                      </button>
                    </div>
                  </form>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </main>

    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="<?= base_url('dist/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/user.js') ?>"></script>

  <script>
    function capitalizeFirstLetter(input) {
      let value = input.value;
      if (value.length > 0) {
        input.value = value.charAt(0).toUpperCase() + value.slice(1);
      }
    }


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

    // Confirmation before saving changes
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to save the changes to your profile?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit the form if confirmed
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


    document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('form[action*="gardian-update-profilepost"]');

  form.addEventListener('submit', function(e) {
    e.preventDefault();

    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(el => el.classList.remove('is-invalid'));

    const firstName = form.querySelector('input[name="first_name"]');
    const lastName = form.querySelector('input[name="last_name"]');
    const relationship = form.querySelector('select[name="relationship"]');
    const contact = form.querySelector('input[name="contact_number"]');
    const email = form.querySelector('input[name="email"]');
    const municipality = form.querySelector('select[name="municipality"]');
    const barangay = form.querySelector('select[name="barangay"]');
    const street = form.querySelector('input[name="street"]');

    let isValid = true;

    // Check required fields
    [firstName, lastName, relationship, municipality, barangay].forEach(field => {
      if (!field.value.trim()) {
        field.classList.add('is-invalid');
        isValid = false;
      }
    });

    if (!isValid) {
      Swal.fire({
        icon: 'warning',
        title: 'Missing Fields',
        text: 'Please fill in all required fields before saving.',
        confirmButtonColor: '#3085d6'
      });
      return;
    }

    // Contact number (if provided)
    if (contact.value.trim() && !/^[0-9]{11}$/.test(contact.value.trim())) {
      contact.classList.add('is-invalid');
      Swal.fire({
        icon: 'error',
        title: 'Invalid Contact Number',
        text: 'Contact number must be 11 digits.',
        confirmButtonColor: '#3085d6'
      });
      return;
    }

    // Email (if provided)
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (contact.value.trim() && !/^09[0-9]{9}$/.test(contact.value.trim())) {
  contact.classList.add('is-invalid');
  Swal.fire({
    icon: 'error',
    title: 'Invalid Contact Number',
    text: 'Contact number must be 11 digits and start with "09".',
    confirmButtonColor: '#3085d6'
  });
  return;
}



    // Confirmation alert
    Swal.fire({
      title: 'Save changes?',
      text: 'Are you sure you want to update your profile?',
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
  });
});

// Auto-capitalize first letter of each word
function capitalizeFirstLetter(input) {
  input.value = input.value.replace(/\b\w/g, char => char.toUpperCase());
}

    

  </script>
</body>

</html>
