<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside  Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">
</head>

<body>
  <div class="wrapper d-flex">
    <!-- Sidebar -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 min-vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img src="assets/img/logoicon.png" alt="Logo" class="me-3 ms-1" style="width: 38px;">
        <span class="text-primary fw-bold fs-3">Brightside</span>
      </div>
      <div class="d-flex flex-column align-items-start">
        <hr class="mb-2" />
        <a href="<?= base_url('student-dashboard'); ?>" class="nav-link d-flex align-items-center ">         
          <i class="fas fa-star me-4 fa-lg fa-fw text-secondary"></i> Highlight
        </a>
        <a href="<?= base_url('student-classes'); ?>" class="nav-link d-flex align-items-center ">
          <i class="fas fa-book me-4 fa-lg fa-fw text-secondary"></i> Materials
        </a>
        <a href="<?= base_url('student-progress-report'); ?>" class="nav-link d-flex align-items-center  ">
          <i class="fas fa-chart-line me-4 fa-lg fa-fw text-secondary"></i> Progress Report
        </a>
        <a href="<?= base_url('student-guardiansetup'); ?>" class="nav-link d-flex align-items-center">
          <i class="fas fa-users me-4 fa-lg fa-fw text-secondary"></i> Guardian Setup
        </a>
        <a href="<?= base_url('student-attendance'); ?>" class="nav-link d-flex align-items-center">
          <i class="fas fa-calendar-check me-4 fa-lg fa-fw text-secondary"></i> Attendance
        </a>
        
        <!-- <a href="<?= base_url('student-interactive-learning'); ?>" class="nav-link d-flex align-items-center active">
          <i class="fa-solid fa-chalkboard me-4 fa-lg fa-fw text-secondary"></i> Interactive Learning
        </a> -->
      </div>
      <div class="mt-auto mb-3">
          <hr>
          <span class="fw-bold text-secondary small ms-1">Parent</span>
          <ul class="list-unstyled ms-1 mt-2">
                <a  class="text-decoration-none" href="<?= base_url('/guardian/dashboard/' . esc($student->parent_id)) ?>">
                      <img src="<?= base_url('public/assets/profilepic/' . esc($parentData->parentProfilepic)) ?>" alt="Parent"
                          class="rounded-circle border border-2 me-2" width="25" height="25">
                    <span class="text-primary fw-bold"><?= esc($parentData->parentfull_name) ?></span>
                </a>
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
            <h5 class="text-primary m-0 ms-3 ">Interactive Learning</h5>
          </div>
          <?php 
            $hasUnread = false;
            if (!empty($notification)) {
                foreach ($notification as $n) {
                    if ($n['is_read'] == 0) {
                        $hasUnread = true;
                        break; 
                    }
                }
            }
            ?>

          <div class="d-flex align-items-center ms-auto py-1">
            <div class="dropdown me-3 position-relative border-start border-2 ps-3 ">
                <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                  <?php if ($hasUnread): ?>
                      <!-- Red dot only -->
                      <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                  <?php endif; ?>
                </a>
               <ul class="dropdown-menu dropdown-menu-end shadow-sm overflow-auto" aria-labelledby="notifDropdown" style="width: 350px; max-height:320px;">
                <li class="dropdown-header fw-bold">Notifications</li>
                <li><hr class="dropdown-divider"></li>

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
            
           

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                 id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                 <img  src="<?= base_url('public/assets/profilepic/' . esc($student->profile_pic)) ?>"  alt="Profile Picture"
                    class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2"><?= esc($student->full_name) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('student-profile'); ?>"><i class='fa-solid fa-user me-3 mb-2 text-primary mt-2'></i>Profile</a></li>                
                <li><hr class="dropdown-divider"></li>
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
            <!-- Page Content -->
      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <div class="container-fluid">
          <h2 class="mb-4 text-primary">Engaging Learning Games</h2>

          <div class="row g-6">
            <!-- Coloring Fun -->
            <div class="col-md-4">
              <div class="card shadow-sm border-0 h-100 text-center bg-pink p-4 rounded-4">
                <div class="card-body">
                  <i class="fas fa-paint-brush text-danger fs-1 mb-3"></i>
                  <h5 class="fw-bold text-dark">Coloring Fun</h5>
                  <p class="text-muted small">Fill in drawings with colors that stay neatly inside the lines.</p>
                </div>
                <a href="<?= base_url(); ?>student-coloring-game" class="btn btn-outline-danger w-100">Play Now</a>
              </div>
            </div>

            <!-- Shape Matcher -->
            <div class="col-md-4">
              <div class="card shadow-sm border-0 h-100 text-center bg-green p-4 rounded-4">
                <div class="card-body">
                  <i class="fas fa-shapes text-success fs-1 mb-3"></i>
                  <h5 class="fw-bold text-dark">Shape Matcher</h5>
                  <p class="text-muted small">Match the shapes and improve visual recognition skills.</p>
                </div>
                <a href="<?= base_url(); ?>student-shape-game" class="btn btn-outline-success w-100">Play Now</a>
              </div>
            </div>

            <!-- Animal Names -->
            <div class="col-md-4">
              <div class="card shadow-sm border-0 h-100 text-center bg-blue p-4 rounded-4">
                <div class="card-body">
                  <i class="fas fa-paw text-primary fs-1 mb-3"></i>
                  <h5 class="fw-bold text-dark">Animal Names</h5>
                  <p class="text-muted small">Click each animal emoji to hear its name. Learn and have fun with all the animals!</p>
                </div> 
                <a href="<?= base_url(); ?>student-animal-game" class="btn btn-outline-primary w-100">Play Now</a>
              </div>
            </div>
          </div>

          <div class="row g-4 mt-2">
            <!-- Count the number -->
           <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 text-center bg-yellow p-4 rounded-4">
              <div class="card-body">
                <i class="fas fa-dice text-warning fs-1 mb-3"></i>
                <h5 class="fw-bold text-dark">Number Names</h5>
                <p class="text-muted small">Click each number to hear its name. Learn and have fun counting all numbers!</p>
              </div>
              <a href="<?= base_url(); ?>student-number-game" class="btn btn-outline-warning w-100">Play Now</a>
            </div>
          </div>


            <!-- Sound Memory -->
            <div class="col-md-4">
              <div class="card shadow-sm border-0 h-100 text-center bg-purple p-4 rounded-4">
                <div class="card-body">
                  <i class="fas fa-palette text-info fs-1 mb-3"></i>
                  <h5 class="fw-bold text-dark">Color Memory</h5>
                  <p class="text-muted small">Listen and match the colors with their sounds. Boost memory and have fun!</p>
                </div>
                <a href="<?= base_url(); ?>student-color-game" class="btn btn-outline-info w-100">Play Now</a>
              </div>
            </div>
          </div>
        </div>
      </main>

    </div>
  </div>

  <!-- Sidebar Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/admin.js"></script>
</body>

</html>
