<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <!-- Favicon -->
  <link href="assets/img/logoicon.png" rel="icon" />

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet" />


  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Flaticon Font -->
  <link href="assets/lib/flaticon/font/flaticon.css" rel="stylesheet" />

  <!-- bootstrap link -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css">

  <!-- custom style Link -->
  <link rel="stylesheet" href="assets/css/website.css">


  
</head>

<body>
  <!-- Navbar Start -->
    <div class="container-fluid bg-light position-relative shadow">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
            <a href="" class="navbar-brand">
                <img class="logo" src="assets/img/logo.png" alt="" style="width: 230px;">
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav fw-bold fs-5 mx-auto py-0">
                <a href="<?= base_url('/') ?>" class="nav-item nav-link active">Home</a>
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
  
    <div class="container-fluid bg-primary px-0 px-md-5 mb-5">
      <div class="row align-items-center px-3">
        <div class="col-lg-6 text-lg-left">
          <h4 class="text-white fs-3 fw-semibold mb-4 mt-5 mt-lg-0">Brightside Global Learning Center</h4>
          <h1 class="display-5 fw-bold text-white">
            A Fun and Creative Way to Learn
          </h1>
          <p class="text-white mb-4">
            At our play-based learning center, children explore, discover, and grow through hands-on activities that inspire creativity, 
            build confidence, and develop essential life skills—all in a safe and joyful environment.
          </p>
          <a href="<?= base_url(); ?>signup" class="btn btn-secondary mt-1 py-3 px-5">Pre-Register</a>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
          <img class="img-fluid mt-5" src="assets/img/header.png" alt="Happy kids learning and playing" />
        </div>
      </div>
    </div>


  <!-- Header End -->

  <div class="container-fluid pt-5">
    <div class="container pb-3">
      <div class="row">
        <!-- Play Ground -->
        <div class="col-lg-4 col-md-6 pb-1">
          <div class="d-flex bg-light shadow-sm border-top rounded mb-4 p-4">
            <div>
              <i class="fa-solid fa-tree fa-xl text-primary"></i>
            </div>
            <div class="ps-3">
              <h4 class="text-primary">Play Ground</h4>
              <p class="m-0">A safe and fun area for kids to run, play, and explore with friends.</p>
            </div>
          </div>
        </div>

        <!-- Music and Dance -->
        <div class="col-lg-4 col-md-6 pb-1">
          <div class="d-flex bg-light shadow-sm border-top rounded mb-4 p-4">
            <div>
              <i class="fa-solid fa-drum fa-xl text-primary"></i>
            </div>
            <div class="ps-3">
              <h4 class="text-primary">Music and Dance</h4>
              <p class="m-0">Children learn rhythm, coordination, and expression through fun music activities.</p>
            </div>
          </div>
        </div>

        <!-- Arts and Crafts -->
        <div class="col-lg-4 col-md-6 pb-1">
          <div class="d-flex bg-light shadow-sm border-top rounded mb-4 p-4">
            <div>
              <i class="fa-solid fa-palette fa-xl text-primary"></i>
            </div>
            <div class="ps-3">
              <h4 class="text-primary">Arts and Crafts</h4>
              <p class="m-0">Creative activities that help improve motor skills and imagination.</p>
            </div>
          </div>
        </div>

        <!-- Story Time -->
        <div class="col-lg-4 col-md-6 pb-1">
          <div class="d-flex bg-light shadow-sm border-top rounded mb-4 p-4">
            <div>
              <i class="fa-solid fa-book-open fa-xl text-primary"></i>
            </div>
            <div class="ps-3">
              <h4 class="text-primary">Story Time</h4>
              <p class="m-0">Encourages love for reading while teaching moral lessons and listening skills.</p>
            </div>
          </div>
        </div>

        <!-- Nutritious Meals -->
        <div class="col-lg-4 col-md-6 pb-1">
          <div class="d-flex bg-light shadow-sm border-top rounded mb-4 p-4">
            <div>
              <i class="fa-solid fa-puzzle-piece fa-xl text-primary"></i>
            </div>
            <div class="ps-3">
              <h4 class="text-primary">Learning Through Play</h4>
              <p class="m-0">Fun activities that build knowledge, critical thinking, and social skills.</p>
            </div>
          </div>
        </div>


        <!-- Educational Tour -->
        <div class="col-lg-4 col-md-6 pb-1">
          <div class="d-flex bg-light shadow-sm border-top rounded mb-4 p-4">
            <div>
              <i class="fa-solid fa-school-flag fa-xl text-primary"></i>
            </div>
            <div class="ps-3">
              <h4 class="text-primary">Educational Tour</h4>
              <p class="m-0">Fun trips outside the classroom to discover new things and learn through experience.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- About Start -->
  <div class="container-fluid py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5">
          <img class="img-fluid rounded mb-5 mb-lg-0" src="assets/img/bestschool.jpg" alt="Teacher helping kids in classroom" />
        </div>
        <div class="col-lg-7">
          <p class="section-title pe-5">
            <span class="pe-2">Learn About Us</span>
          </p>
          <h1 class="mb-4">A Place Where Kids Learn and Grow</h1>
          <p>
            We are a fun and friendly learning center where kids play, discover, and grow. Our teachers care for every child and guide them in learning through games, music, art, and teamwork. We help build confidence and love for learning from an early age.
          </p>
          <div class="row pt-2 pb-4">
            <div class="col-6 col-md-4">
              <img class="img-fluid rounded" src="assets/img/blog-3.jpg" alt="Happy children learning" />
            </div>
            <div class="col-6 col-md-8">
              <ul class="list-inline m-0">
                <li class="py-2 border-top border-bottom">
                  <i class="fa fa-check text-primary me-3"></i>Creative and fun activities
                </li>
                <li class="py-2 border-bottom">
                  <i class="fa fa-check text-primary me-3"></i>Caring and trained teachers
                </li>
                <li class="py-2 border-bottom">
                  <i class="fa fa-check text-primary me-3"></i>Safe and friendly environment
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->


  <!-- Class Start -->
  <div class="container-fluid pt-5">
    <div class="container p-1">
      <div class="text-center pb-2">
        <p class="section-title px-5">
          <span class="px-2">Popular Classes</span>
        </p>
        <h1 class="mb-4">Classes for Your Kids</h1>
      </div>

      <!-- Responsive Row -->
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-center">

        <!-- Toddler Class -->
        <div class="col mb-5 px-5 py-2">
          <div class="card border-0 bg-light shadow-sm h-100 pb-2">
            <img class="card-img-top mb-2 class-img" src="assets/img/classPic6.jpg" alt="">
            <div class="card-body text-center">
              <h4 class="card-title">Toddler Class</h4>
              <p class="card-text">
                A gentle introduction to school for toddlers, focusing on play, basic routines, and social development.
              </p>
            </div>
            <div class="card-footer bg-transparent py-4 px-5">
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Age of Kids</strong></div>
                <div class="col-6 py-1">2 - 3 Years</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Total Seats</strong></div>
                <div class="col-6 py-1">30 Seats</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Class Time</strong></div>
                <div class="col-6 py-1">10:00 - 12:00</div>
              </div>
              <div class="row">
                <div class="col-6 py-1 text-end border-end"><strong>Tuition Fee</strong></div>
                <div class="col-6 py-1">2000 / Month</div>
              </div>
            </div>
            <button class="btn btn-primary px-4 mx-auto mb-2 view-details-btn"
                data-bs-toggle="modal" data-bs-target="#classDetailsModal"
                data-title="Nursery Class"
                data-reqs="<ul><li>Birth Certificate (Photocopy)</li><li>2 pcs 1x1 ID Pictures</li></ul>"
                data-apply="Pre-register online through the school portal. After submission, wait for an email confirming whether your pre-registration is approved or not. The email will include the list of enrollment requirements and your scheduled date to visit the school for enrollment."
                data-info="Nursery is designed for toddlers to learn through play, songs, and structured routines.">View Details</button>
          </div>
        </div>

        <!-- Nursery -->
        <div class="col mb-5 px-5 py-2">
          <div class="card border-0 bg-light shadow-sm h-100 pb-2">
            <img class="card-img-top mb-2 class-img" src="assets/img/classPic2.jpg" alt="">
            <div class="card-body text-center">
              <h4 class="card-title">Nursery</h4>
              <p class="card-text">
                Fun, hands-on activities that develop early literacy, motor skills, and confidence.
              </p>
            </div>
            <div class="card-footer bg-transparent py-4 px-5">
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Age of Kids</strong></div>
                <div class="col-6 py-1">3 - 4 Years</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Total Seats</strong></div>
                <div class="col-6 py-1">30 Seats</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Class Time</strong></div>
                <div class="col-6 py-1">08:00 - 10:00</div>
              </div>
              <div class="row">
                <div class="col-6 py-1 text-end border-end"><strong>Tuition Fee</strong></div>
                <div class="col-6 py-1">2500 / Month</div>
              </div>
            </div>
            <button class="btn btn-primary px-4 mx-auto mb-2 view-details-btn"
                data-bs-toggle="modal" data-bs-target="#classDetailsModal"
                data-title="Pre Kindergarten Class"
                data-reqs="<ul><li>Birth Certificate (Photocopy)</li><li>2 pcs 2x2 ID Pictures</li></ul>"
                data-apply="Pre-register online through the school portal. After submission, wait for an email confirming whether your pre-registration is approved or not. The email will include the list of enrollment requirements and your scheduled date to visit the school for enrollment."
                data-info="Nursery introduces young learners to basic concepts through play, music, and hands-on activities that support social interaction and motor development.">View Details</button>
          </div>
        </div>

        <!-- Pre Kindergarten -->
        <div class="col mb-5 px-5 py-2">
          <div class="card border-0 bg-light shadow-sm h-100 pb-2">
            <img class="card-img-top mb-2 class-img" src="assets/img/classPic3.jpg" alt="">
            <div class="card-body text-center">
              <h4 class="card-title">Pre Kindergarten</h4>
              <p class="card-text">
                Builds early learning skills through structured play and creative activities.
              </p>
            </div>
            <div class="card-footer bg-transparent py-4 px-5">
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Age of Kids</strong></div>
                <div class="col-6 py-1">4 - 5 Years</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Total Seats</strong></div>
                <div class="col-6 py-1">30 Seats</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Class Time</strong></div>
                <div class="col-6 py-1">80:00 - 10:00</div>
              </div>
              <div class="row">
                <div class="col-6 py-1 text-end border-end"><strong>Tuition Fee</strong></div>
                <div class="col-6 py-1">2500 / Month</div>
              </div>
            </div>
            <button class="btn btn-primary px-4 mx-auto mb-2 view-details-btn"
                data-bs-toggle="modal" data-bs-target="#classDetailsModal"
                data-title="Pre Kindergarten Class"
                data-reqs="<ul><li>Birth Certificate (Photocopy)</li><li>2 pcs 2x2 ID Pictures</li></ul>"
                data-apply="Pre-register online through the school portal. After submission, wait for an email confirming whether your pre-registration is approved or not. The email will include the list of enrollment requirements and your scheduled date to visit the school for enrollment."
                data-info="Pre-K focuses on fun activities that develop literacy, motor skills, and early problem-solving abilities.">View Details</button>
          </div>
        </div>

        <!-- Junior Kindergarten -->
        <div class="col mb-5 px-5 py-2">
          <div class="card border-0 bg-light shadow-sm h-100 pb-2">
            <img class="card-img-top mb-2 class-img" src="assets/img/classPic10.jpg" alt="">
            <div class="card-body text-center">
              <h4 class="card-title">Junior Kindergarten</h4>
              <p class="card-text">
                Builds basics in reading, math, and communication through play and group activities.
              </p>
            </div>
            <div class="card-footer bg-transparent py-4 px-5">
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Age of Kids</strong></div>
                <div class="col-6 py-1">5 Years</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Total Seats</strong></div>
                <div class="col-6 py-1">30 Seats</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Class Time</strong></div>
                <div class="col-6 py-1">10:00 - 12:00</div>
              </div>
              <div class="row">
                <div class="col-6 py-1 text-end border-end"><strong>Tuition Fee</strong></div>
                <div class="col-6 py-1">2500 / Month</div>
              </div>
            </div>
            <button class="btn btn-primary px-4 mx-auto mb-2 view-details-btn"
                data-bs-toggle="modal" data-bs-target="#classDetailsModal"
                data-title="Junior Kindergarten"
                data-reqs="<ul><li>Birth Certificate (Photocopy)</li><li>2 pcs ID Pictures</li></ul>"
                data-apply="Pre-register online through the school portal. After submission, wait for an email confirming whether your pre-registration is approved or not. The email will include the list of enrollment requirements and your scheduled date to visit the school for enrollment."
                data-info="Junior Kindergarten develops reading, basic math, and communication skills through group and interactive learning.">View Details</button>
          </div>
        </div>

        <!-- Senior Kindergarten -->
        <div class="col mb-5 px-5 py-2">
          <div class="card border-0 bg-light shadow-sm h-100 pb-2">
            <img class="card-img-top mb-2 class-img" src="assets/img/classPic1.jpg" alt="">
            <div class="card-body text-center">
              <h4 class="card-title">Senior Kindergarten</h4>
              <p class="card-text">
                Strengthens school readiness with more advanced literacy and problem-solving skills.
              </p>
            </div>
            <div class="card-footer bg-transparent py-4 px-5">
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Age of Kids</strong></div>
                <div class="col-6 py-1">6 Years</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Total Seats</strong></div>
                <div class="col-6 py-1">30 Seats</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-end border-end"><strong>Class Time</strong></div>
                <div class="col-6 py-1">01:00 - 03:30</div>
              </div>
              <div class="row">
                <div class="col-6 py-1 text-end border-end"><strong>Tuition Fee</strong></div>
                <div class="col-6 py-1">2500 / Month</div>
              </div>
            </div>
            <button class="btn btn-primary px-4 mx-auto mb-2 view-details-btn"
                data-bs-toggle="modal" data-bs-target="#classDetailsModal"
                data-title="Senior Kindergarten"
                data-reqs="<ul><li>Birth Certificate (Photocopy)</li><li>2 pcs ID Pictures</li></ul>"
                data-apply="Pre-register online through the school portal. After submission, wait for an email confirming whether your pre-registration is approved or not. The email will include the list of enrollment requirements and your scheduled date to visit the school for enrollment."
                data-info="Senior Kindergarten builds independence and readiness for Grade 1, focusing on literacy, numeracy, and critical thinking.">View Details</button>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- Class End -->


  

  <!-- Team Start -->
  <!-- <div class="container-fluid pt-5">
    <div class="container">
      <div class="text-center pb-2">
        <p class="section-title px-5">
          <span class="px-2">Our Teachers</span>
        </p>
        <h1 class="mb-4">Meet Our Teachers</h1>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3 text-center team mb-5">
          <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%">
            <img class="img-fluid w-100" src="assets/img/id.jpg" alt="" />
            <div class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
              <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px" href="#"><i
                  class="fab fa-twitter"></i></a>
              <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px" href="#"><i
                  class="fab fa-facebook-f"></i></a>
              <a class="btn btn-outline-light text-center px-0" style="width: 38px; height: 38px" href="#"><i
                  class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
          <h4>Eirich Elca</h4>
          <i>Music Teacher</i>
        </div>
        <div class="col-md-6 col-lg-3 text-center team mb-5">
          <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%">
            <img class="img-fluid w-100" src="assets/img/id.jpg" alt="" />
            <div class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
              <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px" href="#"><i
                  class="fab fa-twitter"></i></a>
              <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px" href="#"><i
                  class="fab fa-facebook-f"></i></a>
              <a class="btn btn-outline-light text-center px-0" style="width: 38px; height: 38px" href="#"><i
                  class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
          <h4>Malupiton</h4>
          <i>Language Teacher</i>
        </div>
        <div class="col-md-6 col-lg-3 text-center team mb-5">
          <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%">
            <img class="img-fluid w-100" src="assets/img/id.jpg" alt="" />
            <div class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
              <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px" href="#"><i
                  class="fab fa-twitter"></i></a>
              <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px" href="#"><i
                  class="fab fa-facebook-f"></i></a>
              <a class="btn btn-outline-light text-center px-0" style="width: 38px; height: 38px" href="#"><i
                  class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
          <h4>Roldan Oliveros</h4>
          <i>Dance Teacher</i>
        </div>
        <div class="col-md-6 col-lg-3 text-center team mb-5">
          <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%">
            <img class="img-fluid w-100" src="assets/img/id.jpg" alt="" />
            <div class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
              <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px" href="#"><i
                  class="fab fa-twitter"></i></a>
              <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px" href="#"><i
                  class="fab fa-facebook-f"></i></a>
              <a class="btn btn-outline-light text-center px-0" style="width: 38px; height: 38px" href="#"><i
                  class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
          <h4>Batman</h4>
          <i>Art Teacher</i>
        </div>
      </div>
    </div>
  </div> -->
  <!-- Team End -->

    <!-- Footer Start -->
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
  <!-- Reusable Class Details Modal -->
  <div class="modal fade" id="classDetailsModal" tabindex="-1" aria-labelledby="classDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="classDetailsModalLabel">Class Details</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h6 class="fw-bold">Requirements</h6>
          <div id="modal-reqs"></div>

          <h6 class="fw-bold mt-3">How to Apply</h6>
          <p id="modal-apply"></p>

          <h6 class="fw-bold mt-3">Other Information</h6>
          <p id="modal-info"></p>
        </div>
        <div class="modal-footer">
          <a href="<?= base_url(); ?>signup" class="btn btn-primary">Pre-Register</a>
          
        </div>
      </div>
    </div>
  </div>


  <!-- Back to Top -->
  <a href="#" class="btn btn-primary p-3 back-to-top text-white" id="backToTopBtn">
    <i class="fa fa-angle-double-up"></i>
  </a>

  <script src="assets/js/main.js"></script>
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const viewButtons = document.querySelectorAll(".view-details-btn");
      const modalTitle = document.getElementById("classDetailsModalLabel");
      const modalReqs = document.getElementById("modal-reqs");
      const modalApply = document.getElementById("modal-apply");
      const modalInfo = document.getElementById("modal-info");

      viewButtons.forEach(btn => {
        btn.addEventListener("click", function () {
          modalTitle.textContent = this.getAttribute("data-title");
          modalReqs.innerHTML = this.getAttribute("data-reqs");
          modalApply.textContent = this.getAttribute("data-apply");
          modalInfo.textContent = this.getAttribute("data-info");
        });
      });
    });
  </script>
</body>

</html>