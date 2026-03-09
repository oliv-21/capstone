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
          <a href="<?= base_url('/') ?>" class="nav-item nav-link ">Home</a>
          <a class="nav-link active" href="<?= base_url(); ?>about">About</a>
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
      <h3 class="display-3 fw-bold text-white">About Us</h3>
      <div class="d-inline-flex text-white">
        <p class="m-0"><a class="text-white" href="<?= base_url('/') ?>">Home</a></p>
        <p class="m-0 px-2">/</p>
        <p class="m-0">About Us</p>
      </div>
    </div>
  </div>
  <!-- Header End -->

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

  <!-- Facilities Start -->
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

  <!-- Facilities Start -->

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
            <img class="img-fluid w-100" src="assets/img/parent1.jpg" alt="" />
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
            <img class="img-fluid w-100" src="assets/img/parent1.jpg" alt="" />
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
            <img class="img-fluid w-100" src="assets/img/parent1.jpg" alt="" />
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
            <img class="img-fluid w-100" src="assets/img/parent1.jpg" alt="" />
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

  <!-- Back to Top -->
  <a href="#" class="btn btn-primary p-3 back-to-top text-white" id="backToTopBtn">
    <i class="fa fa-angle-double-up"></i>
  </a>


  <!-- Tempsate Javascript -->
  <script src="assets/js/main.js"></script>
  <script src="dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>