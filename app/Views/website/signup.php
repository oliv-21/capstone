<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside - Guardian Signup</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon -->
  <link href="assets/img/logoicon.png" rel="icon" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Bootstrap -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css">

  <!-- Custom CSS -->
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
          <a href="<?= base_url('/') ?>" class="nav-item nav-link">Home</a>
          <a href="<?= base_url(); ?>about" class="nav-item nav-link">About</a>
          <a href="<?= base_url(); ?>classes" class="nav-item nav-link">Classes</a>
          <!-- <a href="<?= base_url(); ?>teacher" class="nav-item nav-link">Teachers</a> -->
          <a href="<?= base_url(); ?>contact" class="nav-item nav-link">Contact</a>
        </div>
        <a href="<?= base_url(); ?>login" class="btn btn-secondary px-5 fw-bold text-white">Login</a>
      </div>
    </nav>
  </div>
  <!-- Navbar End -->

  <!-- Header -->
  <div class="container-fluid bg-primary text-white d-flex flex-column align-items-center justify-content-center" style="min-height: 160px;">
    <h3 class="display-5 fw-bold">Guardian Signup</h3>
    <div>
      <a href="<?= base_url('/') ?>" class="text-white">Home</a> /
      <span>Signup</span>
    </div>
  </div>

  <!-- Signup Form -->
  <div class="container-fluid mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-lg">
          <div class="card-header bg-primary border-0 text-center">
            <h4 class="text-white pt-2">Create Guardian Account</h4>
          </div>

          <div class="card-body p-4">
            <?php if (isset($validate_msg)): ?>
              <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= $validate_msg->listErrors(); ?>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <form id="guardianForm" method="post" action="<?= base_url('signupPost') ?>" enctype="multipart/form-data" novalidate>
              <h5 class="fw-bold mt-2">Guardian Information</h5>
              <hr class="bg-secondary">

              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="firstname" name="first_name" placeholder="Enter first name" required oninput="capitalizeFirstLetter(this)">
                  <div class="invalid-feedback">First name is required.</div>
                </div>

                <div class="col-md-4">
                  <label for="middlename" class="form-label">Middle Name</label>
                  <input type="text" class="form-control" id="middlename" name="middle_name" placeholder="Enter middle name (optional)" oninput="capitalizeFirstLetter(this)">
                </div>

                <div class="col-md-4">
                  <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="lastname" name="last_name" placeholder="Enter last name" required oninput="capitalizeFirstLetter(this)">
                  <div class="invalid-feedback">Last name is required.</div>
                </div>
              </div>

              <div class="row mb-3 align-items-end">
                <div class="col-md-4">
                  <label for="relationship" class="form-label">Relationship <span class="text-danger">*</span></label>
                  <select name="relationship" id="relationship" class="form-control" required>
                    <option value="">-- Select Relationship --</option>
                    <option value="Mother">Mother</option>
                    <option value="Father">Father</option>
                    <option value="Guardian">Guardian</option>
                    <option value="Sibling">Sibling</option>
                    <option value="Other">Other</option>
                  </select>
                  <div class="invalid-feedback">Please select a relationship.</div>
                </div>

                <div class="col-md-4 d-none" id="otherRelationshipDiv">
                  <label for="other_relationship" class="form-label">Specify Relationship</label>
                  <input type="text" class="form-control" id="other_relationship" name="other_relationship" placeholder="Please specify" oninput="capitalizeFirstLetter(this)">
                </div>

                <div class="col-md-4">
                  <label for="contactnumber" class="form-label">Contact Number <span class="text-danger">*</span></label>
                  <input type="tel" class="form-control" id="contactnumber" name="contact_number" pattern="[0-9]{11}" maxlength="11" placeholder="e.g. 09123456789" required>
                  <div class="invalid-feedback">Please enter a valid 11-digit contact number.</div>
                </div>
              </div>

              <!-- Username and Email -->
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                  <div class="invalid-feedback">Username is required.</div>
                </div>

                <div class="col-md-6">
                  <label for="email" class="form-label">Active Email Address <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                  <div class="invalid-feedback">A valid email is required.</div>
                </div>
              </div>

              <!-- Password -->
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Minimum 6 characters" minlength="6" required>
                  <div class="invalid-feedback">Please enter a password (min 6 characters).</div>
                </div>

                <div class="col-md-6">
                  <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                  <div class="invalid-feedback">Passwords must match.</div>
                </div>
              </div>

              <!-- Address Info -->
              <h5 class="fw-bold mt-4">Address Information</h5>
              <hr class="bg-secondary">

              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="municipality" class="form-label">Municipality <span class="text-danger">*</span></label>
                  <select id="municipality" name="municipality" class="form-control" required>
                    <option value="">Select Municipality</option>
                  </select>
                  <div class="invalid-feedback">Please select your municipality.</div>
                </div>

                <div class="col-md-4">
                  <label for="barangay" class="form-label">Barangay <span class="text-danger">*</span></label>
                  <select id="barangay" name="barangay" class="form-control" required>
                    <option value="">Select Barangay</option>
                  </select>
                  <div class="invalid-feedback">Please select your barangay.</div>
                </div>

                <div class="col-md-4">
                  <label for="street" class="form-label">Street</label>
                  <input type="text" class="form-control" id="street" name="street" placeholder="Enter street name" oninput="capitalizeFirstLetter(this)">
                </div>
              </div>

              <div class="d-grid">
                <button type="submit" id="signupBtn" class="btn btn-primary mt-4">Sign Up</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid bg-tertiary text-white mt-5 py-5 px-sm-3 px-md-5">
    <div class="row pt-5">
      <div class="col-lg-5 col-md-6 mb-5">
        <a href="" class="navbar-brand m-0 mb-4 p-0"
          style="font-size: 40px; line-height: 40px">
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

  <!-- JS -->
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>

  <script>
    // Capitalize helper
    function capitalizeFirstLetter(input) {
      input.value = input.value.replace(/\b\w/g, char => char.toUpperCase());
    }

    // Show or hide "Other" relationship field
    document.getElementById("relationship").addEventListener("change", function () {
      const otherDiv = document.getElementById("otherRelationshipDiv");
      const otherInput = document.getElementById("other_relationship");
      if (this.value === "Other") {
        otherDiv.classList.remove("d-none");
        otherInput.required = true;
      } else {
        otherDiv.classList.add("d-none");
        otherInput.required = false;
        otherInput.value = "";
      }
    });

    // Load municipalities and barangays
    document.addEventListener("DOMContentLoaded", function () {
      const municipalitySelect = document.getElementById("municipality");
      const barangaySelect = document.getElementById("barangay");

      fetch("https://psgc.gitlab.io/api/provinces/043400000/municipalities")
        .then(res => res.json())
        .then(data => {
          municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
          data.forEach(muni => {
            const opt = document.createElement("option");
            opt.value = muni.name;
            opt.textContent = muni.name;
            municipalitySelect.appendChild(opt);
          });
        });

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

    // Validate form and confirm before submit
    document.getElementById("signupBtn").addEventListener("click", function (e) {
      e.preventDefault();

      const form = document.getElementById("guardianForm");
      form.classList.add("was-validated");

      if (!form.checkValidity()) {
        Swal.fire({
          icon: "warning",
          title: "Incomplete Fields",
          text: "Please fill out all required fields correctly before submitting."
        });
        return;
      }

      const pass = document.getElementById("password").value.trim();
      const confirm = document.getElementById("confirm_password").value.trim();

      if (pass !== confirm) {
        Swal.fire("Password Mismatch", "Passwords do not match.", "error");
        return;
      }

      Swal.fire({
        title: "Confirm Signup?",
        text: "Please review your information before creating an account.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Sign Up"
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });

    <?php if (session()->getFlashdata('error')): ?>
      Swal.fire({
        icon: 'error',
        title: 'Sorry',
        text: '<?= session()->getFlashdata('error'); ?>',
        confirmButtonColor: '#d33'
      });
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '<?= session()->getFlashdata('success'); ?>',
        confirmButtonColor: '#3085d6'
      });
    <?php endif; ?>
    document.querySelectorAll('#guardianForm input[type="text"], #guardianForm textarea').forEach(input => {
      input.addEventListener('input', function () {
        this.value = this.value.replace(/<|>/g, '');
      });
    });
  </script>
</body>
</html>
