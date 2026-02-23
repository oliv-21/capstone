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
  
  <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css') ?>">

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="<?=base_url('assets/css/admin.css')?>">
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
              
               
                 
                </span>
             
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
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4 p-1">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>

          <div class="d-flex align-items-center ms-auto py-1">
            <div class="dropdown me-3 position-relative border-start border-2 ps-3">
              <a href="#" class="text-decoration-none text-primary" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="notifDropdown" style="width: 300px;">
                <li class="dropdown-header fw-bold">Notifications</li>
                <li><hr class="dropdown-divider"></li>
                <li class="px-3 py-2 small text-muted">No new notifications</li>
              </ul>
            </div>

            <!-- Chat Dropdown -->
            <div class="dropdown me-3 position-relative border-start border-2 ps-3">
               <a href="<?= base_url(); ?>admin-chats" class="text-decoration-none text-primary">
                <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
              </a>
            </div>

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

      <main class="px-3 py-3">
        <h2 class="mb-3 text-primary">Messages</h2>
        <div class="row">
                    <!-- Contact List (on top on small screens) -->
                    <div class="col-12 col-md-4 order-1 order-md-0 mb-4">
                        <div class="card border-0 shadow-sm " style= "height: 78vh;">
                            <div class="card-header bg-white fw-bold">Messages</div>
                            <div class="list-group list-group-flush overflow-auto" style="max-height: 78vh;">
                                
                                <?php foreach ($contacts as $contact): ?>
                                    <a href="<?= site_url('admin-chats/' . $contact['id']) ?>"  class="list-group-item list-group-item-action d-flex align-items-start">
                                       <img src="<?= base_url('public/assets/profilepic/' . ($contact['profile_pic'] ?? 'default.jpg')) ?>" class="rounded-circle me-3" alt="User" width="40" height="40">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                            <strong><?= esc($contact['full_name']) ?></strong>
                                            <small class="text-muted"><?= $contact['sent_at'] ? time_elapsed_string($contact['sent_at']) : '' ?></small>
                                            
                                            </div>
                                            <div class="small text-muted text-truncate"> <?= esc($contact['last_message'] ?? 'Start chatting...') ?></div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>

                    <!-- Chat Box -->
                    <div class="col-12 col-md-8 order-0 order-md-1">
                        <?php if (isset($receiver)): ?>
                            <div class="card border-0 shadow-sm d-flex flex-column" style="height: 70vh;">

                                <div class="card-header bg-white fw-bold">
                                    <img   src="<?= base_url('public/assets/profilepic/' . ($receiver['profile_pic'] ?? 'default.jpg')) ?>"  class="rounded-circle me-3" alt="User" width="40" height="40">
                                     <?= esc($receiver['full_name']) ?>
                                </div>
                                
                                <!-- Messages -->
                                <div class="card-body overflow-auto" style="flex: 1;">
                                    <?php foreach ($messages as $msg): ?>
                                        <?php if ($msg['sender_id'] != session()->get('user_id')): ?>
                                            
                                            <!-- Incoming message -->
                                            <div class="mb-3">
                                                <div class="bg-light rounded p-2 mb-1 d-inline-block w-auto w-md-75">
                                                   <?= esc($msg['message']) ?>
                                                </div>
                                                <br>
                                                <!-- <small class="text-muted">2 minutes ago</small> -->
                                            </div>
                                        <?php else: ?>
                                            <!-- Outgoing message -->
                                            <div class="text-end mb-3">
                                                <div class="bg-secondary text-white rounded p-2 mb-1 d-inline-block w-auto w-md-75">
                                                    <?= esc($msg['message']) ?>
                                                </div>
                                                <br>
                                                <!-- <small class="text-muted">1 minute ago</small> -->
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </div>

                                <!-- Message Input -->
                                <div class="card-footer bg-white">
                                    <form class="d-flex flex-row flex-sm-row" method="post" action="<?= base_url('student-chat/send-admin') ?>">
                                        <input type="hidden" name="receiver_id" value="<?= esc($receiver['id']) ?>">
                                        <input type="text" name='message' class="form-control me-sm-2 mb-2 mb-sm-0" placeholder= "Type a message...">
                                        <button type="submit" class="btn btn-primary ms-2 ms-sm-2 mb-2 mb-sm-0 w-25 w-sm-auto">
                                            <i class="fa-solid fa-paper-plane"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php else: ?>
                            
                        <?php endif; ?>

                    </div>

                </div>
      </main>



    </div>
  </div>

  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
<!-- JavaScript Files -->
<script src="<?= base_url('dist/js/jquery.min.js') ?>"></script>
<script src="<?= base_url('dist/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/admin.js') ?>"></script>



</body>

</html>