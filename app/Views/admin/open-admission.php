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
  <link rel="stylesheet" href="assets/css/admin.css">

  <!-- oliveros_add -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- DataTables CSS -->
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
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>

          <div class="d-flex align-items-center ms-auto py-1">
            <a href="#" class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-bell fa-lg fa-fw" ></i>
            </a>
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
        <h2 class="text-primary mb-4">
          <i onclick="window.location.href='<?= base_url(); ?>admin-admission'" class="fas fa-arrow-left me-3" style="cursor: pointer;"></i>Admission
        </h2>

        <!-- Admission Controller Section -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-primary text-white">
            <i class="fa-solid fa-gear me-2"></i> Admission Controller
          </div>
          <div class="card-body">
            <form action="<?= base_url('admission/save') ?>"  method="post" id="admissionForm">
              
              <!-- Date Settings -->
              <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label for="openingDate" class="form-label fw-semibold">Admission Opening Date</label>
                <input type="date" name="openingDate" id="openingDate" class="form-control" required
                      value="<?= isset($admissions) && $admissions->opendate ? htmlspecialchars($admissions->opendate) : '' ?>">
              </div>
              <div class="col-md-6">
                <label for="closingDate" class="form-label fw-semibold">Admission Closing Date</label>
                <input type="date" name="closingDate" id="closingDate" class="form-control" required
                      value="<?= isset($admissions) && $admissions->closedate ? htmlspecialchars($admissions->closedate) : '' ?>">
              </div>
            </div>

              <!-- Note -->
              <div class="alert alert-info mb-4">
                <strong>Note:</strong> Please add all the <strong>classes</strong> that will be offered for the upcoming school year along with their corresponding <strong>tuition fees</strong>.
              </div>

              <!-- Class Entries -->
              <div id="classContainer">
                <div class="row g-3 align-items-end class-row mb-2">
                  <div class="col-md-4">
                    <label class="form-label">Class Name</label>
                    <input type="text" name="classes[0][name]" class="form-control" placeholder="e.g., Grade 1" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Full Payment(₱)</label>
                    <input type="number" name="classes[0][fee]" class="form-control" placeholder="e.g., 15000" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Monthly Fee (₱)</label>
                    <input type="number" name="classes[0][monthlyfee]" class="form-control" placeholder="e.g., 1000" required>
                  </div>
                   <div class="col-md-4">
                    <label class="form-label">Miscellaneous Fee (₱)</label>
                    <input type="number" name="classes[0][miscellaneous]" class="form-control" placeholder="e.g., 1000" required>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-class d-none"><i class="fa-solid fa-minus"></i></button>
                  </div>
                </div>
              </div>

              <!-- Add More Classes -->
              <div class="text-end mb-4">
                <button type="button" class="btn btn-secondary" id="addClassBtn">
                  <i class="fa-solid fa-plus"></i> Add Another Class
                </button>
              </div>

              <!-- Submit Button -->
              <div class="text-end">
                <button type="submit" class="btn btn-success px-4">
                  <i class="fa-solid fa-check me-2"></i>Open Admission
                </button>
                
              </div>
            </form>
          </div>
        </div>
      </main>

    </div>
  </div>

  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/admin.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
  let classIndex = 1;
  const addClassBtn = document.getElementById('addClassBtn');
  const classContainer = document.getElementById('classContainer');
  const admissionForm = document.getElementById('admissionForm');

  // Add new class row
  if (addClassBtn && classContainer) {
    addClassBtn.addEventListener('click', function () {
      const newRow = document.createElement('div');
      newRow.classList.add('row', 'g-3', 'align-items-end', 'class-row', 'mb-2');
      newRow.innerHTML = `
        <div class="col-md-4">
          <label class="form-label">Class Name</label>
          <input type="text" name="classes[${classIndex}][name]" class="form-control" placeholder="e.g., Grade ${classIndex + 1}" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Tuition Fee (₱)</label>
          <input type="number" name="classes[${classIndex}][fee]" class="form-control" placeholder="e.g., 15000" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Monthly Fee (₱)</label>
          <input type="number" name="classes[${classIndex}][monthlyfee]" class="form-control" placeholder="e.g., 1000" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Miscellaneous Fee (₱)</label>
          <input type="number" name="classes[${classIndex}][miscellaneous]" class="form-control" placeholder="e.g., 1000" required>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-danger remove-class"><i class="fa-solid fa-minus"></i></button>
        </div>
      `;
      classContainer.appendChild(newRow);
      classIndex++;
    });

    // Remove class row
    classContainer.addEventListener('click', function (e) {
      if (e.target.closest('.remove-class')) {
        e.target.closest('.class-row').remove();
      }
    });
  }

  // Form validation and submission
  if (admissionForm) {
    admissionForm.addEventListener("submit", function (e) {
      const openingDateInput = document.getElementById("openingDate");
      const closingDateInput = document.getElementById("closingDate");

      const openingDate = new Date(openingDateInput.value);
      const closingDate = new Date(closingDateInput.value);
      const today = new Date();
      today.setHours(0, 0, 0, 0); // Reset to midnight for accurate comparison

      if (!openingDateInput.value || !closingDateInput.value) {
        e.preventDefault();
        alert("Please select both opening and closing dates.");
        return;
      }

      if (openingDate <= today) {
        e.preventDefault();
        alert("Admission opening date must be in the future.");
        return;
      }

      if (closingDate <= today) {
        e.preventDefault();
        alert("Admission closing date must be in the future.");
        return;
      }

      if (openingDate >= closingDate) {
        e.preventDefault();
        alert("Opening date must be earlier than closing date.");
        return;
      }

      // Disable button to prevent resubmit
      const submitBtn = admissionForm.querySelector("button[type='submit']");
      submitBtn.disabled = true;
      submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin me-2"></i>Submitting...`;
    });
  }
});


  </script>
    

  <!-- JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


</body>

</html>
