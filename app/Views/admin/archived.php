<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Admin Archived</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css">

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="assets/css/admin.css">
  <link href="assets/img/logoicon.png" rel="icon" />
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
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>

          <div class="d-flex align-items-center ms-auto py-1">
            <select id="school_year" class="form-select">

              <?php foreach ($yearsRecord as $r): ?>
                <option value="<?= $r['id'] ?>" 
                  <?= ($r['id'] == $selectedOpeningId) ? 'selected' : '' ?>>
                  <?= $r['school_year'] ?>
                </option>
              <?php endforeach; ?>
            </select>
            <a href="" class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-bell fa-lg fa-fw"></i>
            </a>
            <a href="<?= base_url(); ?>admin-chats" class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
            </a>

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($profilepic)) ?>" alt="Profile Image"
                  class="me-2 rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                <span class="fw-bold ms-2">Admin</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('adminProfile'); ?>"><i
                      class='fa-solid fa-user me-3 mb-3 text-primary mt-2'></i>Profile</a></li>
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
        <h2 class="text-primary mb-4">
          <i onclick="window.location.href='<?= base_url(); ?>admin-admission'" class="fas fa-arrow-left me-3"></i>Archived
        </h2>

        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="primary-table-header">
              <tr>
                <th>Applicant Name</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody id="admissionTable">
              <?php foreach ($members as $member): ?>
                <tr>
                  <td><?= esc($member->full_name) ?></td>
                  <td><?= esc($member->status) ?></td>
                  <td class="text-center">
                    <button class="btn btn-info btn-sm text-white px-4 me-4" data-bs-toggle="modal"
                      data-bs-target="#admissionModal"
                      data-picture="<?= esc($member->picture ?? '') ?>"
                      data-psa="<?= esc($member->psa ?? '') ?>"
                      data-firstname="<?= esc($member->first_name) ?>"
                      data-middlename="<?= esc($member->middle_name) ?>"
                      data-lastname="<?= esc($member->last_name) ?>"
                      data-nickname="<?= esc($member->nickname) ?>"
                      data-nationality="<?= esc($member->nationality) ?>"
                      data-gender="<?= esc($member->gender) ?>"
                      data-birthday="<?= esc($member->birthday) ?>"
                      data-age="<?= esc($member->age) ?>"
                      data-class="<?= esc($member->class_applied) ?>"
                      data-fathername="<?= esc($member->father_name) ?>"
                      data-fatherocc="<?= esc($member->father_occupation) ?>"
                      data-mothername="<?= esc($member->mother_name) ?>"
                      data-motherocc="<?= esc($member->mother_occupation) ?>"
                      data-contact="<?= esc($member->contact_number) ?>"
                      data-email="<?= esc($member->email) ?>"
                      data-status="<?= esc($member->status) ?>"
                      data-address="<?= esc($member->address) ?>"
                      data-admission_id="<?= esc($member->admission_id) ?>">
                      View
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <!-- Modal -->
          <div class="modal fade" id="admissionModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <h1 class="modal-title fs-5 text-white">
                    <i class="fa-solid fa-file-lines text-white me-2"></i> Applicant Information
                  </h1>
                  <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-primary mb-0">
                      <i class="fa-solid fa-user-graduate me-2"></i> Student Information
                    </h5>
                   
                  </div>

                  <div class="mb-3 ps-5">
                    <img id="modal-picture" src="" alt="2x2 Picture"
                      class="img-thumbnail me-3"
                      style="width: 120px; height: 120px; object-fit: cover;">
                  </div>

                  <div class="mb-3 ps-5">
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
                      <div class="col-8" id="modal-class"></div>
                    </div>
                  </div>

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
                    <i class="fa-solid fa-file me-2"></i> Documents
                  </h5>
                  <div class="mb-3 ps-5">
                    <img id="modal-psa" src="" alt="PSA Document" class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                    <br>
                    <a id="psa-download" href="#" class="btn btn-outline-primary btn-sm mt-2" download>
                      <i class="fa-solid fa-download me-1"></i> Download PSA
                    </a>
                  </div>
                </div>

                <form id="statusForm" action="<?= base_url('admin-archived-restore') ?>" method="post">
                  <input type="hidden" name="admission_id" id="modalAdmissionId">
                  <input type="hidden" name="status" id="modalStatus">

                  <div class="modal-footer">
                    <button type="button" class="btn btn-success text-white" onclick="submitStatus('Pending')">
                      Restore
                    </button>
                  </div>
                </form>
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
        </div>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    const modal = document.getElementById('admissionModal');
    modal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;

      // Populate text fields
      [
        'firstname', 'middlename', 'lastname', 'nickname', 'nationality', 'gender',
        'birthday', 'age', 'class', 'fathername', 'fatherocc', 'mothername',
        'motherocc', 'contact', 'email', 'address'
      ].forEach(field => {
        document.getElementById('modal-' + field).textContent = button.getAttribute('data-' + field) || '';
      });

      // Admission ID
      document.getElementById('modalAdmissionId').value = button.getAttribute('data-admission_id');

      // Picture
      const picture = button.getAttribute('data-picture') || '';
      const picturePath = picture
        ? "<?= base_url('public/assets/profilepic/') ?>" + picture
        : "<?= base_url('public/assets/profilepic/default.webp') ?>";
      document.getElementById('modal-picture').setAttribute('src', picturePath);

      // PSA
      const psa = button.getAttribute('data-psa') || '';
      const psaPath = psa
        ? "<?= base_url('public/assets/psa/') ?>" + psa
        : "<?= base_url('public/assets/profilepic/default.webp') ?>";
      document.getElementById('modal-psa').setAttribute('src', psaPath);
      document.getElementById('psa-download').setAttribute('href', psaPath);
    });

    function submitStatus(status) {
      Swal.fire({
        title: 'Restore Admission?',
        text: "Are you sure you want to restore this student's admission?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Restore',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d'
      }).then(result => {
        if (result.isConfirmed) {
          document.getElementById('modalStatus').value = status;
          document.getElementById('statusForm').submit();
        }
      });
    }
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
