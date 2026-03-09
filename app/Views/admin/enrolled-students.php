<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Admin Enrolled Student</title>
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
  <link rel="stylesheet" href="assets/css/admin.css">
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
         
        <a href="<?= base_url(); ?>admin-admission" class="nav-link d-flex align-items-center position-relative">
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

        <a href="<?= base_url(); ?>admin-enrolled" class="nav-link d-flex align-items-center active">
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


            <a href="<?= base_url(); ?>admin-chats"
              class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
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
        <h2 class="mb-4 text-primary">Enrolled Students</h2>

        <div class="container-fluid d-flex align-items-center justify-content-between mb-3 flex-column flex-sm-row">
          <div class="d-flex align-items-center col-12 col-sm-3 flex-row mt-3 mt-sm-0">
            <label for="class" class="form-label fw-bold text-secondary me-2 mb-0 fs-5 bg">Class</label>
              <select class="form-select rounded border-secondary" id="class">
              <?php if (!empty($classes)): ?>
                <?php foreach ($classes as $index => $class): ?>
                  <option value="<?= esc($class['classname']) ?>" <?= $index === 0 ? 'selected' : '' ?>>
                    <?= esc($class['classname']) ?>
                  </option>
                <?php endforeach; ?>
              <?php else: ?>
                <option disabled selected>No classes available</option>
              <?php endif; ?>
            </select>

          </div>
        </div>

        <div class="table-responsive">
          <!-- Table -->
          <table class="table table-responsive table-hover align-middle" id="membersTable" class="table table-striped table-bordered">
            <thead class="primary-table-header">
              <tr>
                <th>Full Name (Last, First, M.I.)</th>
                <th>Age</th>
                <th>Class</th>
                <th>Contact Person</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="admissionTable">
              <?php foreach ($students as $student): ?>
              <tr>
                <td><?= esc($student->full_name); ?></td>
                <td>
                  <?php
                    if (!empty($student->birthday)) {
                        $birthdate = new DateTime($student->birthday);
                        $today = new DateTime();
                        $age = $today->diff($birthdate)->y;
                        echo esc($age);
                    } else {
                        echo esc($student->age ?? '-');
                    }
                  ?>
                </td>
                <td><?= esc($student->class_level) ?></td>
                <td><?= esc($student->mother_name ?? '-') ?></td>
                <td>
                  <button class="btn btn-info btn-sm text-white px-4" data-bs-toggle="modal" data-bs-target="#mymodal"
                    data-firstname="<?= esc($student->first_name) ?>"
                    data-middlename="<?= esc($student->middle_name) ?>"
                    data-lastname="<?= esc($student->last_name) ?>"
                    data-nickname="<?= esc($student->nickname) ?>"
                    data-nationality="<?= esc($student->nationality) ?>"
                    data-gender="<?= esc($student->gender) ?>"
                    data-birthday="<?= esc($student->birthday) ?>"
                    data-age="<?= esc($student->age) ?>"
                    data-class="<?= esc($student->class_level) ?>"
                    data-fathername="<?= esc($student->father_name) ?>"
                    data-fatherocc="<?= esc($student->father_occupation) ?>"
                    data-mothername="<?= esc($student->mother_name) ?>"
                    data-motherocc="<?= esc($student->mother_occupation) ?>"
                    data-contact="<?= esc($student->contact_number) ?>"
                    data-email="<?= esc($student->email) ?>"
                    data-address="<?= esc($student->address) ?>"
                    data-picture="<?= esc($student->picture) ?>"
                    data-psa="<?= esc($student->psa) ?>"
                    data-municipality="<?= esc($student->municipality) ?>"
                    data-barangay="<?= esc($student->barangay) ?>"
                    data-street="<?= esc($student->street) ?>"
                    data-admission_id="<?=esc($student->admission_id)?>">
                    Details
                  </button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <!-- Student Modal -->
          <div class="modal fade" id="mymodal">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-primary">
        <h1 class="modal-title fs-5 text-white">
          <i class="fa-solid fa-file-lines text-white me-2"></i> Student Information
        </h1>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="studentForm" action="<?= base_url('/update-student-enrolled') ?>" method="post" enctype="multipart/form-data">

          <!-- Student Information -->
          <h5 class="text-primary"><i class="fa-solid fa-user-graduate me-2"></i> Student Information</h5>

          <div class="d-flex align-items-center mb-3 ms-5">
            <!-- Image Preview -->
            <img id="modal-picture" src="" alt="2x2 Picture" class="img-thumbnail me-3"
                style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;">

            <!-- File Input for Upload -->
            <input type="file" id="modal-picture-file" name="picture" class="form-control" accept="image/*">
          </div>

          <div class="mb-3 ps-5">
            <input type="hidden" id="modal-admission_id" name="admission_id" />

            <div class="row mb-1">
              <div class="col-4"><strong>First Name:</strong></div>
              <div class="col-8"><input type="text" id="modal-firstname" name="first_name" class="form-control" required></div>
            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>Middle Name:</strong></div>
              <div class="col-8"><input type="text" id="modal-middlename" name="middle_name" class="form-control"></div>
            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>Last Name:</strong></div>
              <div class="col-8"><input type="text" id="modal-lastname" name="last_name" class="form-control"required></div>
            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>Nickname:</strong></div>
              <div class="col-8"><input type="text" id="modal-nickname" name="nickname" class="form-control"></div>
            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>Nationality:</strong></div>
              <div class="col-8"><input type="text" id="modal-nationality" name="nationality" class="form-control"></div>
            </div>

            <div class="row mb-1">
              <div class="col-4"><strong>Gender:</strong></div>
              <div class="col-8">
                <select id="modal-gender" name="gender" class="form-control">
                  <option value="">Select Gender</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-4"><strong>Birthday:</strong></div>
              <div class="col-8">
                <input type="date" id="modal-birthday" name="birthday" class="form-control" onchange="computeAge()">
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>Age:</strong></div>
              <div class="col-8">
                <input type="number" id="modal-age" name="age" class="form-control" readonly>
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>Municipality</strong></div>
              <div class="col-8"><select name="municipality" id="modal-municipality" class="form-control" required>
                    <option value="">Select Municipality</option>
                  </select></div>
            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>Barangay</strong></div>
              <div class="col-8"><select id="modal-barangay" name="barangay" class="form-control" required>
                    <option value="">Select Barangay</option>
                  </select></div>
            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>Street</strong></div>
              <div class="col-8"><input type="text" id="modal-street" name="street" class="form-control"></div>
            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>Class:</strong></div>
              <div class="col-8">
                <select id="modal-class" name="class_level" class="form-control">
                  <option value="">Select Class</option>
                  <?php foreach ($classes as $class): ?>
                    <option value="<?= esc($class['classname']) ?>">
                      <?= esc($class['classname']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <!-- Parent Information -->
          <h5 class="text-primary"><i class="fa-solid fa-users me-2"></i> Parent Information</h5>
          <div class="mb-3 ps-5">
            <div class="row mb-1">
              <div class="col-4"><strong>Father's Name:</strong></div>
              <div class="col-8"><input type="text" id="modal-fathername" name="father_name" class="form-control"></div>
            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>Father's Occupation:</strong></div>
              <div class="col-8"><input type="text" id="modal-fatherocc" name="father_occupation" class="form-control"></div>
            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>Mother's Name:</strong></div>
              <div class="col-8"><input type="text" id="modal-mothername" name="mother_name" class="form-control" required></div>
            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>Mother's Occupation:</strong></div>
              <div class="col-8"><input type="text" id="modal-motherocc" name="mother_occupation" class="form-control"></div>
            </div>
          </div>

          <!-- Contact Information -->
          <h5 class="text-primary"><i class="fa-solid fa-address-book me-2"></i> Contact Information</h5>
          <div class="mb-3 ps-5">
            <div class="row mb-1">
              <div class="col-4"><strong>Contact Number:</strong></div>
             <div class="col-8">
                <input type="text" 
                      id="modal-contact" 
                      name="contact_number" 
                      class="form-control" 
                      required
                      pattern="\d{11}" 
                      title="Contact number must be exactly 11 digits">
                <div class="invalid-feedback">
                  Please enter a valid 11-digit contact number.
                </div>
              </div>

            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>Email:</strong></div>
              <div class="col-8"><input type="email" id="modal-email" name="email" class="form-control" required ></div>
            </div>
            <div class="row mb-1">
              <div class="col-4"><strong>PSA</strong></div>
              <div class="col-8">
                <input type="file" id="modal-psa-file" name="psa" class="form-control" accept="image/*,application/pdf">
                <img src="" id="modal-psa" alt="PSA Document" class="img-fluid rounded shadow-sm mt-2" style="max-height: 150px;">
                <br>
                <a id="psa-download" href="#" class="btn btn-outline-primary btn-sm mt-2" download>
                  <i class="fa-solid fa-download me-1"></i> Download PSA
                </a>
              </div>
            </div>

          </div>

          <!-- Modal Footer -->
          <div class="modal-footer">
            <a id="generateID" href="#" class="btn btn-success me-auto" target="_blank">Generate ID</a>
            <a id="printLink" class="btn btn-outline-secondary" href="#" target="_blank">Print</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            
          </div>

        </form>
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

  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function () {
        var table = $('#membersTable').DataTable();

        // Filter by class
        // $('#class').on('change', function () {
        //     table.column(2).search($(this).val()).draw();
        // });
         $('#class').on('change', function () {
      table.column(2).search(this.value).draw(); // column index 2 = Class
    });

    // ✅ Automatically trigger filter on page load for selected class
    var selectedClass = $('#class').val();
    if(selectedClass){
      table.column(2).search(selectedClass).draw();
    }
    });

    // Student modal
    var myModal = document.getElementById('mymodal');
    myModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        //     ['firstname','middlename','lastname','nickname','nationality','birthday','age','class','fathername','fatherocc','mothername','motherocc','contact','email','address']
        // .forEach(id => {
        //     var value = button.getAttribute('data-'+id) || '';
        //     var input = document.getElementById('modal-'+id);
        //     if(input.tagName.toLowerCase() === 'input') input.value = value;
        // });
        // var classValue = button.getAttribute('data-class') || '';
        // document.getElementById('modal-class').value = classValue; // ✅ correct
        
        


        

        var picture = button.getAttribute('data-picture') || '';
        var picturePath = picture ? "<?= base_url('public/assets/profilepic/') ?>" + picture : "<?= base_url('public/assets/2x2/default.webp') ?>";

        // Small picture
        document.getElementById('modal-picture').src = picturePath;
        // Large picture
        document.getElementById('large-picture').src = picturePath;


        var psa = button.getAttribute('data-psa') || '';
        var psaPath = psa 
        ? "<?= base_url('public/assets/psa/') ?>" + psa 
        : "<?= base_url('public/assets/2x2/default.webp') ?>";
        document.getElementById('modal-psa').src = psaPath;

   
        var psaDownload = document.getElementById('psa-download');
        if (psa) {
            psaDownload.href = psaPath;
            psaDownload.style.display = 'inline-block';
        } else {
            psaDownload.href = '#';
            psaDownload.style.display = 'none'; 
        }


      ['firstname','middlename','lastname','nickname','nationality','birthday','age','fathername','fatherocc','mothername','motherocc','contact','email','municipality','barangay','street','admission_id']
      .forEach(id => {
          var input = document.getElementById('modal-'+id);
          if(input) input.value = button.getAttribute('data-'+id) || '';
      });

    
      var classSelect = document.getElementById('modal-class');
      var genderSelect = document.getElementById('modal-gender');

      if(classSelect) classSelect.value = button.getAttribute('data-class') || '';
      if(genderSelect) genderSelect.value = button.getAttribute('data-gender') || '';

      
      var admissionId = button.getAttribute('data-admission_id') || '';
      document.getElementById('modal-admission_id').value = admissionId;

      
      var printLink = document.getElementById('printLink');
      if(printLink) {
          printLink.href = "<?= site_url('admin/print-student/') ?>" + admissionId;
      }
     
      var generateID = document.getElementById('generateID');
      if(generateID) {
          generateID.href = "<?= site_url('admin/generateId/') ?>" + admissionId;
      }
    });

    // Open large picture modal
    document.getElementById('modal-picture').addEventListener('click', function () {
        var viewModal = new bootstrap.Modal(document.getElementById('viewPictureModal'));
        viewModal.show();
    });


    const studentForm = document.getElementById('studentForm');

  studentForm.addEventListener('submit', function(e) {
    e.preventDefault(); // prevent default submission
    studentForm.classList.add('was-validated'); // Bootstrap validation class

    // Check required fields
    if (!studentForm.checkValidity()) {
      Swal.fire({
        icon: "warning",
        title: "Incomplete Fields",
        text: "Please fill out all required fields correctly before submitting."
      });
      return;
    }

    // Confirmation before submitting
    Swal.fire({
      title: "Confirm Submission",
      text: "Do you want to save the student details?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, save it!",
      cancelButtonText: "Cancel"
    }).then((result) => {
      if (result.isConfirmed) {
        studentForm.submit(); // submit if confirmed
      }
    });
  });

    function computeAge() {
  const birthDate = new Date(document.getElementById('modal-birthday').value);
  if (isNaN(birthDate)) return;
  const today = new Date();
  let age = today.getFullYear() - birthDate.getFullYear();
  const m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  document.getElementById('modal-age').value = age;
}
  document.addEventListener("DOMContentLoaded", function () {
    const municipalitySelect = document.getElementById("modal-municipality");
    const barangaySelect = document.getElementById("modal-barangay");

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

    function markAsRead(userId) {
      fetch("<?= base_url('notifications/markAsRead/') ?>" + userId)
        .then(response => {
          if (response.ok) {
            const badge = document.getElementById('notifBadge');
            if (badge) badge.style.display = 'none';
          }
        });
    }
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
