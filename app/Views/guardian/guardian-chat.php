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
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css') ?>">
  <link href="assets/img/logoicon.png" rel="icon" />
  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">

</head>

<body>
  <div class="wrapper">

    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 min-vh-100 d-flex flex-column">
      <?php
        $hasChildren = !empty($childrens) && count($childrens) > 0;
      ?>
      <div>
        <div class="d-flex align-items-center mb-2 mt-3">
          <img src="<?= base_url('assets/img/logoicon.png') ?>" alt="Logo" class="me-3 ms-1" style="width: 38px;">
          <span class="text-primary fw-bold fs-3">Brightside</span>
        </div>

        <div class="d-flex flex-column align-items-start">
          <hr class="mb-2" />
          <a href="<?= base_url('guardian/dashboard'); ?>" class="nav-link d-flex align-items-center  ">
            <i class="fas fa-child me-4 fa-lg fa-fw text-secondary"></i>
            Admission
          </a>
          <a href="<?= base_url('/guardian-announcement/' . esc($students->user_id)); ?>"
            class="nav-link d-flex align-items-center <?= !$hasChildren ? 'disabled-link' : '' ?> ">
              <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i>
              Announcement
          </a>

          <a href="<?= base_url('/payment-history/'. esc($students->user_id)); ?>"
            class="nav-link d-flex align-items-center <?= !$hasChildren ? 'disabled-link' : '' ?> ">
            <i class="fa-solid fa-money-bill me-4 fa-lg fa-fw text-secondary"></i> Payment
          </a>
        </div>
      </div>

      <!-- Children Section -->
      <div class="mt-5">
        <hr>
        <span class="fw-bold text-secondary small ms-1">Children</span>
        <ul class="list-unstyled ms-1 mt-2">
          <?php if (!empty($childrens)): ?>
          <?php foreach ($childrens as $child): ?>
          <li class="dropdown-item-text d-flex align-items-center mt-2">
            <a href="<?= base_url('/StudentviewDashboard/' . $child->admission_id) ?>"
              class="d-flex align-items-center text-decoration-none">
              <img src="<?= base_url('public/assets/profilepic/' . esc($child->profile_pic)) ?>" alt="Child"
                class="rounded-circle border border-2 me-2" width="25" height="25">
              <span class="text-primary fw-bold"><?= esc($child->full_name) ?></span>
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

      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>
          <div class="text-primary m-0 ms-3 d-none d-md-block">
            <h5 class="text-primary m-0 ms-3 ">Chat</h5>
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
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                <?php if ($hasUnread): ?>
                <!-- Red dot only -->
                <!-- <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"></span> -->
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
                  <strong>
                    <?= esc($n['title']) ?>
                  </strong><br>
                  <span class="text-muted">
                    <?= esc($n['message']) ?>
                  </span>
                </li>
                <?php endforeach; ?>
                <?php else: ?>
                <li class="px-3 py-2 small text-muted">No new notifications</li>
                <?php endif; ?>
              </ul>
            </div>

            <a href="<?= base_url(); ?>student-chat"
              class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
            </a>

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($students->profile_pic)) ?>"
                  alt="Profile Picture" class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2"><?= esc($students->full_name) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('guardian-Profile'); ?>"><i
                      class="fa-solid fa-user me-3 mb-2 text-primary mt-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="<?= base_url('guardian-resetPassword'); ?>"><i
                      class="fa-solid fa-key me-3 mb-2 text-primary mt-2"></i>Reset Password</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
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
        <h2 class="text-primary mb-4 d-block d-md-none">Messages</h2>
        <div class="row">
          <!-- Contact List (on top on small screens) -->
          <div class="col-12 col-md-4 order-1 order-md-0 mb-4">
            <div class="card border-0 shadow-sm " style="height: 80vh;">
              <div class="card-header bg-white fw-bold">Messages</div>
              <div class="list-group list-group-flush overflow-auto" style="max-height: 80vh;">

                <?php foreach ($contacts as $contact): ?>
                <a href="<?= site_url('student-chat/' . $contact['id']) ?>"
                  class="list-group-item list-group-item-action d-flex align-items-start">
                  <img src="<?= base_url('public/assets/profilepic/' . ($contact['profile_pic'] ?? 'default.jpg')) ?>"
                    class="rounded-circle me-3" alt="User" width="40" height="40">

                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center">
                      <strong>
                        <?= esc($contact['full_name']) ?>
                        <?php if (!empty($contact['unread_count']) && $contact['unread_count'] > 0): ?>
                        <!-- <span class="badge bg-danger rounded-pill ms-2">
                                                            
                                                            </span> -->
                        <?php endif; ?>
                      </strong>
                      <small class="text-muted">
                        <?= $contact['sent_at'] ? time_elapsed_string($contact['sent_at']) : '' ?>
                      </small>
                    </div>
                    <div class="small text-muted text-truncate">
                      <?= esc($contact['last_message'] ?? 'Start chatting...') ?>
                    </div>
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
                <img src="<?= base_url('public/assets/profilepic/' . ($receiver['profile_pic'] ?? 'default.jpg')) ?>"
                  class="rounded-circle me-3" alt="User" width="40" height="40">
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
                <form class="d-flex flex-row flex-sm-row" method="post"
                  action="<?= base_url('student-chat/send') ?>">
                  <input type="hidden" name="receiver_id" value="<?= esc($receiver['id']) ?>">
                  <input type="text" name='message' class="form-control me-sm-2 mb-2 mb-sm-0"
                    placeholder="Type a message...">
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
  <script src="<?= base_url('dist/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/user.js') ?>"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
      document.addEventListener('DOMContentLoaded', () => {
      const disabledLinks = document.querySelectorAll('.disabled-link');
      disabledLinks.forEach(link => {
        link.addEventListener('click', (e) => {
          e.preventDefault(); // Prevent navigation
          Swal.fire({
            icon: 'warning',
            title: 'Please wait!',
            text: 'You need to finish your enrollment first. Please go back to the Admission page to complete it.',

            timer: 2000,
            showConfirmButton: false
          });
        });
      });
    });
  </script>


</body>

</html>