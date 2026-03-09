<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Chat</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="assets/img/logoicon.png" rel="icon" />
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>

<body>
  <div class="wrapper d-flex">
    <!-- Sidebar -->
    <nav id="teacherSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img id="schoolLogo" src="<?= base_url('assets/img/logoicon.png') ?>" alt="Logo" class="me-3 ms-1" style="width: 38px;">
        <span id="schoolName" class="text-primary fw-bold fs-3">Brightside</span>
      </div>
      <div class="d-flex flex-column align-items-start">
        <hr class="mb-2" />
        <a href="<?= base_url(); ?>teacher-dashboard" class="nav-link d-flex align-items-center active">
          <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i> Dashboard
        </a>
        <a href="<?= base_url(); ?>teacher-students" class="nav-link d-flex align-items-center">
          <i class="fas fa-chalkboard-teacher me-4 fa-lg fa-fw text-secondary"></i> Enrolled Students
        </a>
        <a href="<?= base_url(); ?>teacher-grades" class="nav-link d-flex align-items-center">
          <i class="fas fa-calendar-check me-4 fa-lg fa-fw text-secondary"></i> Progress Report
        </a>
        <a href="<?= base_url(); ?>teacher-materials" class="nav-link d-flex align-items-center">
          <i class="fas fa-book me-4 fa-lg fa-fw text-secondary"></i> Materials
        </a>
        <a href="<?= base_url(); ?>teacher-annoucement" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-bell me-4 fa-lg fa-fw text-secondary"></i> Announcements
        </a>
        <a href="<?= base_url(); ?>teacher-interactive-learning" class="nav-link d-flex align-items-center">
          <i class="fas fa-layer-group me-4 fa-lg fa-fw text-secondary"></i> Interactive Learning
        </a>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="main col-md-10">
      
        <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4 p-1">
            <div class="container-fluid">
                <button class="btn d-md-none me-2" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="d-flex align-items-center ms-auto py-1">
                    
                    <div class="dropdown me-3 position-relative border-start border-2 ps-3 ">
                      <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                        <!-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">2</span> -->
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end shadow-sm overflow-auto" aria-labelledby="notifDropdown"
                        style="width: 350px; max-height:320px;">
                        <li class="dropdown-header fw-bold">Notifications</li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="px-3 py-2 small">
                          <strong>New Assignment</strong><br>
                          <span class="text-muted">Math worksheet uploaded.</span>
                        </li>
                        <li class="px-3 py-2 small">
                          <strong>New Message</strong><br>
                          <span class="text-muted">Parent sent a message.</span>
                        </li>
                      </ul>
                    </div>
                    <div class="me-3 position-relative border-start border-2 ps-3">
                      <a href="<?= base_url(); ?>teacher-chats" class="text-decoration-none text-primary">
                        <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
                      </a>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="dropdown border-start border-2 ps-4">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                            id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= base_url('public/assets/profilepic/' . esc($profilepics)) ?>" alt="Profile Image" class="me-2 rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                            
                        <span class="fw-bold ms-2"><?= esc($teacher['lastname']) ?></span>

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="<?= base_url('teacherProfile-info'); ?>"><i class='fa-solid fa-user me-3 mb-3 text-primary mt-2'></i>Profile Info</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('teacherProfile'); ?>"><i class='fa-solid fa-lock me-3 mb-3 text-primary mt-2'></i>forget Password</a></li>
                            <li>  <a class="dropdown-item text-danger" href="<?= base_url(); ?>login">
                                <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                            </a>
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
                                    <a href="<?= site_url('teacher-chats/' . $contact['id']) ?>"  class="list-group-item list-group-item-action d-flex align-items-start">
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
                                    <form class="d-flex flex-row flex-sm-row" method="post" action="<?= base_url('teacher-chat/teacher-send') ?>">
                                        <input type="hidden" name="receiver_id" value="<?= esc($receiver['id']) ?>">
                                        <input type="text" name='message' class="form-control me-sm-2 mb-2 mb-sm-0" placeholder= "Type a message...">
                                        <button type="submit" class="btn btn-primary ms-2 ms-sm-2 mb-2 mb-sm-0 w-25 w-sm-auto">
                                            <i class="fa-solid fa-paper-plane"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- <div class="card p-4 text-center shadow-sm">
                                <h5>Select a contact to start chatting</h5>
                            </div> -->
                        <?php endif; ?>

                    </div>

                </div>
      </main>
    </div>
  </div>

  <!-- Sidebar Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src=""></script>
</body>
</html>
