<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Announcement</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css') ?>">
  <link href="../assets/img/logoicon.png" rel="icon" />

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">
    

</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 min-vh-100 d-flex flex-column">
      <div>
        <div class="d-flex align-items-center mb-2 mt-3">
          <img src="<?= base_url('assets/img/logoicon.png') ?>" alt="Logo" class="me-3 ms-1" style="width: 38px;">
          <span class="text-primary fw-bold fs-3">Brightside</span>
        </div>

        <div class="d-flex flex-column align-items-start">
          <hr class="mb-2" />
          <a href="<?= base_url('guardian/dashboard'); ?>" class="nav-link d-flex align-items-center ">
            <i class="fas fa-child me-4 fa-lg fa-fw text-secondary"></i>
            Admission
          </a>
          <a href="<?= base_url('/guardian-announcement/'. esc($students->user_id)); ?>" class="nav-link d-flex align-items-center active ">

            <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i>
            <?php if ($unread_announcement > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= $unread_announcement ?>
              </span>
            <?php endif; ?>
            Announcement
          </a>
          <a href="<?= base_url('/payment-history/'. esc($students->user_id)); ?>" class="nav-link d-flex align-items-center ">
            <i class="fa-solid fa-money-bill me-4 fa-lg fa-fw text-secondary"></i> Payment
          </a>

        </div>
      </div>

  
      <div class="mt-5">
        <hr>
        <span class="fw-bold text-secondary small ms-1">Children</span>
        <ul class="list-unstyled ms-1 mt-2">
          <?php if (!empty($childrens)): ?>
            <?php foreach ($childrens as $child): ?>
              <li class="dropdown-item-text d-flex align-items-center mt-2">
                <a href="<?= base_url('/StudentviewDashboard/' . $child->admission_id) ?>" class="d-flex align-items-center text-decoration-none">
                  <img src="<?= base_url('public/assets/profilepic/' . esc($child->profile_pic)) ?>" 
                    alt="Child" class="rounded-circle border border-2 me-2" width="25" height="25">
                  <span  class="text-primary fw-bold"><?= esc($child->full_name) ?></span>
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
            <h5 class="text-primary m-0 ms-3 ">Announcements</h5>
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
            <select id="school_year" class="form-select">

              <?php foreach ($yearsRecord as $r): ?>
                <option value="<?= $r['id'] ?>" 
                  <?= ($r['id'] == $selectedOpeningId) ? 'selected' : '' ?>>
                  <?= $r['school_year'] ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div class="dropdown me-3 position-relative border-start border-2 ps-3 ">
                <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                  <?php if ($hasUnread): ?>
                      <!-- Red dot only -->
                      <!-- <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"></span> -->
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
            
            <a href="<?= base_url(); ?>student-chat" class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
            </a>

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                 id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                 <img  src="<?= base_url('public/assets/profilepic/' . esc($students->profile_pic)) ?>"  alt="Profile Picture"
                    class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2"><?= esc($students->full_name) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('guardian-Profile'); ?>"><i class='fa-solid fa-user me-3 mb-2 text-primary mt-2'></i>Profile</a></li>
                <li><a class="dropdown-item" href="<?= base_url('guardian-resetPassword'); ?>"><i class='fa-solid fa-key me-3  mb-2 text-primary mt-2'></i>Reset Password</a></li>

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

      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <h2 class="text-primary mb-4 d-block d-md-none">Announcements</h2>

        <?php if (!empty($announcements)): ?>

            <?php 
            // Group announcements by date
            $groupedAnnouncements = [];
            foreach ($announcements as $a) {
                $date = date('F j, Y', strtotime($a->created_at));
                $groupedAnnouncements[$date][] = $a;
            }
            ?>

            <?php foreach ($groupedAnnouncements as $date => $items): ?>
                <!-- Date Header -->
                <div class="">
                    <h5 class="fw-bold text-primary mb-2"><i class="fas fa-bullhorn me-2 fa-sm fa-fw text-secondary"></i><?= $date ?></h5>
                    <hr class="border-dark border-1 mt-0">
                </div>

                <div class="row g-4 mb-5">
                    <?php foreach ($items as $a): ?>
                        <div class="col-12 col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                                <h5 class="text-dark fw-semibold mb-2"><?= esc($a->title) ?></h5>
                             
                                <p class="text-secondary mb-0"><?= esc($a->message) ?></p>
                                <!-- <small class="text-muted mb-3 d-block">Posted: <?= date('F j, Y', strtotime($a->created_at)) ?></small> -->
                                <small class="text-muted mt-3 d-block">Posted by: <?= esc($a->posted_by) ?></small>
                            </div>
                            
                        </div>
                        
                    <?php endforeach; ?>
                </div>

            <?php endforeach; ?>

        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">No announcements available.</div>
            </div>
        <?php endif; ?>

    </main>



    </div>
  </div>

  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="<?= base_url('dist/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/user.js') ?>"></script>
  <script>
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