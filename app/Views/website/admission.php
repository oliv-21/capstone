<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <!-- Favicon -->
  <link href="assets/img/logoicon.png" rel="icon" />

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- bootstrap link -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css">

  <!-- Customized Bootstrap Stylesheet -->
  <link rel="stylesheet" href="assets/css/website.css">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
   <!-- Navbar Start -->
   <div class="container-fluid bg-light position-relative shadow">
    <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
      <a href="<?= base_url('/') ?>" class="navbar-brand">
        <img class="logo" src="assets/img/logo.png" alt="" style="width: 230px;">
      </a>
      <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
        <div class="navbar-nav fw-bold fs-5 mx-auto py-0">
          <a href="<?= base_url('/') ?>" class="nav-item nav-link ">Home</a>
          <a class="nav-link" href="<?= base_url(); ?>about">About</a>
          <a href="<?= base_url(); ?>classes" class="nav-item nav-link">Classes</a>
          <!-- <a href="<?= base_url(); ?>teacher" class="nav-item nav-link">Teachers</a> -->
          <a href="<?= base_url(); ?>contact" class="nav-item nav-link">Contact</a>
        </div>
        <a href="<?= base_url(); ?>login" class="btn btn-primary px-5 fw-bold text-white ">Login</a>
      </div>
    </nav>
  </div>
  <!-- Navbar End -->

  <!-- Header Start -->
  <div class="container-fluid bg-primary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
      <h3 class="dispsay-3 fw-bold text-white">Apply Now!</h3>
      <div class="d-inline-flex text-white">
        <p class="m-0"><a class="text-white" href="<?= base_url('/') ?>">Home</a></p>
        <p class="m-0 px-2">/</p>
        <p class="m-0">Admission</p>
      </div>
    </div>
  </div>
  <div class="container-fluid mt-5">
    <div class="row justify-content-center">
      <?php if ($isAdmissionOpen): ?>
        <div class="col-md-8">
          <div class="card shadow-lg">
            <div class="card-header bg-primary border-0 text-center">
              <h4 class="text-white pt-2">Student Pre-Registration</h4>
            </div>
            <div class="card-body p-4">

          <?php if (isset($validate_msg)): ?>
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert">
              <i class="fas fa-exclamation-triangle me-2"></i>
              <?= $validate_msg->listErrors(); ?>
              <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

              <form id="admissionForm" method="post" action="<?= base_url(); ?>admission" enctype="multipart/form-data">
                <!-- Personal Information -->
                <h5 class=" mt-4">Student Information</h5>
                <hr class="bg-secondary">

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstname" name ="first_name" oninput="capitalizeFirstLetter(this)">
                  </div>
                  <div class="col-md-4">
                    <label for="middlename" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" id="middlename" name = "middle_name" oninput="capitalizeFirstLetter(this)">
                  </div>
                  <div class="col-md-4">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastname" name= "last_name" oninput="capitalizeFirstLetter(this)">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="nickname" class="form-label">Nickname</label>
                    <input type="text" class="form-control" id="nickname" name ="nickname" oninput="capitalizeFirstLetter(this)">
                  </div>
                  <div class="col-md-6">
                    <label for="nationality" class="form-label">Nationality</label>
                    <input type="text" class="form-control" id="nationality" name = "nationality" oninput="capitalizeFirstLetter(this)">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select form-control" id="gender" name= "gender">
                      <option selected disabled>Select gender</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                      <option value="other">Other</option>
                    </select>
                  </div>
                  <div class="col-md-6 ">
                    <label for="birthday" class="form-label">Birthday</label>
                    <input type="date" class="form-control" id="birthday" onchange="computeAge()" name="birthday">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age"  name = "age" readonly  >
                  </div>

                  <div class="col-md-6">
                    <label for="class" class="form-label">Class</label>
                    <select class="form-select form-control" id="class" name="class_applied" required>
                        <option selected disabled>Select a Class</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= esc($class['classname']) ?>">
                                <?= esc($class['classname']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                  </div>
                </div>

                <div class="row mb-5">
                  <div class="col-md-6">
                      <label for="picture" class="form-label">2&times;2 Picture  </label>
                      <input type="file" class="form-control" id="picture1" name="picture" accept="image/*">
                  </div>
                </div>

                <!-- Parents Information -->
                <h5>Parents Information</h5>
                <hr class="bg-secondary">

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="fathername" class="form-label">Father's Name</label>
                    <input type="text" class="form-control" id="fathername" name="father_name" oninput="capitalizeFirstLetter(this)">
                  </div>
                  <div class="col-md-6">
                    <label for="fatheroccupation" class="form-label">Father's Occupation</label>
                    <input type="text" class="form-control" placeholder="N/A" id="fatheroccupation" name="father_occupation" oninput="capitalizeFirstLetter(this)">
                  </div>
                </div>

                <div class="row mb-5 ">
                  <div class="col-md-6">
                    <label for="mothername" class="form-label">Mother's Name</label>
                    <input type="text" class="form-control" id="mothername" name= "mother_name" oninput="capitalizeFirstLetter(this)">
                  </div>
                  <div class="col-md-6">
                    <label for="motheroccupation" class="form-label">Mother's Occupation</label>
                    <input type="text" placeholder="N/A" class="form-control" id="motheroccupation" name="mother_occupation" oninput="capitalizeFirstLetter(this)">
                  </div>
                </div>

                <!-- Contact Information -->
                <h5 class="">Contact Information</h5>
                <hr class="bg-secondary">

                <div class="row mb-5">
                  <div class="col-md-6">
                    <label for="contactnumber" class="form-label">Contact Number</label>
                    <input type="tel" class="form-control" id="contactnumber" name="contact_number">
                  </div>
                  <div class="col-md-6">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name = "email">
                  </div>
                </div>

                <h5 class="">Address Information</h5>
                <hr class="bg-secondary">

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="" class="form-label">Municipality</label>
                    <select name="municipality" id="municipality" class="form-control" required>
                        <option   value="">Select Municipality</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label for="" class="form-label">Barangay</label>
                    <select id="barangay" name="barangay" class="form-control" required>
                        <option value="">Select Barangay</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label for="" class="form-label">Street</label>
                    <input type="text" class="form-control" id="" name="street" oninput="capitalizeFirstLetter(this)">
                  </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                  <button type="button" id="applyBtn" class="btn btn-primary mt-5">Apply</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      <?php else: ?>
          <div class="col-md-8">
              <div class="alert alert-warning text-center shadow-lg mt-5" role="alert">
                  <h4 class="alert-heading">Admission is Currently Closed</h4>
                  <p>We are not accepting applications at this time. Please check back later.</p>
              </div>
          </div>
      <?php endif; ?>
    </div>
  </div>


  <!-- Registration End -->

  <!-- Footer Start -->
  <div class="container-fluid bg-tertiary text-white mt-5 py-5 px-sm-3 px-md-5">
    <div class="row pt-5">
      <div class="col-lg-5 col-md-6 mb-5">
        <a href="" class="navbar-brand m-0 mb-4 p-0" style="font-size: 40px; line-height: 40px">
          <img class="w-75" src="assets/img/logo.png" alt="">
        </a>
      </div>

      <div class="col-lg-4 col-md-6 mb-5">
        <h3 class="text-primary mb-4">Get In Touch</h3>
        <div class="d-flex">
          <h4 class="fa fa-map-marker-alt text-primary"></h4>
          <div class="ps-3">
            <h5 class="text-white">Address</h5>
            <p>Barangay, Bagumbayan, Santa Cruz, Laguna</p>
          </div>
        </div>
        <div class="d-flex">
          <h4 class="fa fa-envelope text-primary"></h4>
          <div class="ps-3">
            <h5 class="text-white">Email</h5>
            <p>brightside@gmail.com</p>
          </div>
        </div>
        <div class="d-flex">
          <h4 class="fa fa-phone-alt text-primary"></h4>
          <div class="ps-3">
            <h5 class="text-white">Phone</h5>
            <p>+012 345 67890</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-5">
        <h3 class="text-primary mb-4">Quick Links</h3>
        <div class="d-flex flex-column justify-content-start">
          <a class="text-white mb-2" href="<?= base_url('/') ?>"><i class="fa fa-angle-right mr-2"></i>Home</a>
          <a class="text-white mb-2" href="<?= base_url(); ?>about"><i class="fa fa-angle-right mr-2"></i>About Us</a>
          <a class="text-white mb-2" href="<?=base_url(); ?>classes"><i class="fa fa-angle-right mr-2"></i>Our Classes</a>
          <!-- <a class="text-white mb-2" href="<?=base_url(); ?>teacher"><i class="fa fa-angle-right mr-2"></i>Our Teachers</a> -->
          <a class="text-white" href="<?=base_url(); ?>contact"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
        </div>
      </div>

    </div>
    <div class="container-fluid pt-5" style="border-top: 1px solid #ff6b6b ;">
      <p class="m-0 text-center text-white">
        &copy;
        <a class="text-primary fw-bold" href="#">Brightside Global Learning Center</a>.
        All Rights Reserved.
      </p>
    </div>
  </div>

  <!-- Back to Top -->
  <a href="#" class="btn btn-primary p-3 back-to-top text-white" id="backToTopBtn">
    <i class="fa fa-angle-double-up"></i>
  </a>
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
  
  <script>
      // SweetAlert2 confirmation before submit
      document.getElementById("applyBtn").addEventListener("click", function () {
        Swal.fire({
          title: "Are you sure?",
          text: "Please confirm your application before submitting.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, submit",
          cancelButtonText: "Cancel"
        }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById("admissionForm").submit();
          }
        });
      });

      // Success popup if session message exists
      <?php if (session()->get('msg_success')): ?>
        Swal.fire({
          title: "Success!",
          text: "<?= session()->get('msg_success'); ?>",
          icon: "success",
          confirmButtonColor: "#3085d6"
        });
      <?php endif; ?>

      // Municipality & Barangay fetch
      document.addEventListener("DOMContentLoaded", function () {
          const municipalitySelect = document.getElementById("municipality");
          const barangaySelect = document.getElementById("barangay");

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
              });

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
  </script>
</body>
</html>
