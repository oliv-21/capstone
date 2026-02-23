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

  <!-- ✅ DataTables Bootstrap 5 CSS -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet" />

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">

</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 min-vh-100 d-flex flex-column">
      <div>
        <div class="d-flex align-items-start mb-2 mt-3">
          <img src="<?= base_url('assets/img/logoicon.png') ?>" alt="Logo" class="me-3 ms-1" style="width: 38px;">
          <span class="text-primary fw-bold fs-3">Brightside</span>
        </div>

        <div class="d-flex flex-column align-items-start">
          <hr class="mb-2" />
          <a href="<?= base_url('guardian/dashboard'); ?>" class="nav-link d-flex align-items-center ">
            <i class="fas fa-child me-4 fa-lg fa-fw text-secondary"></i>
              Admission
          </a>
          <a href="<?= base_url('/guardian-announcement/'. esc($students->user_id)); ?>" class="nav-link d-flex align-items-center ">           
            <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i>
            <?php if ($unread_announcement > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= $unread_announcement ?>
              </span>
            <?php endif; ?>
            Announcement
      
          </a>
          <a href="<?= base_url('/payment-history/'. esc($students->user_id)); ?>" class="nav-link d-flex align-items-center active ">
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
            <li class="dropdown-item-text d-flex align-items-start mt-2">
              <a href="<?= base_url('/StudentviewDashboard/' . $child->admission_id) ?>"
                class="d-flex align-items-end text-decoration-none">
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

    <!-- Main -->
    <div class="main col-md-10">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>
          <div class="text-primary m-0 ms-3 d-none d-md-block">
            <h5 class="text-primary m-0 ms-3 ">Payment History</h5>
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

          <div class="d-flex align-items-start ms-auto py-1">
             <select id="school_year" class="form-select">

              <?php foreach ($yearsRecord as $r): ?>
                <option value="<?= $r['id'] ?>" 
                  <?= ($r['id'] == $selectedOpeningId) ? 'selected' : '' ?>>
                  <?= $r['school_year'] ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div class="dropdown me-3 position-relative border-start border-2 ps-3 ">
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm overflow-auto" aria-labelledby="notifDropdown"
                style="width: 350px; max-height:320px;">
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

            <a href="<?= base_url(); ?>student-chat"
              class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
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

      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <div class="container py-4">
          <div class="mb-5">
            <button onclick="window.location.href='<?= base_url('parent-paymentInfo/' . esc($students->user_id)); ?>'"
              style="width: 100%; padding: 15px; background: #4CAF50; color: white; border: none; border-radius: 8px; margin-bottom: 15px; cursor: pointer;">
              Pay Miscellaneous
            </button>

            <button onclick="window.location.href='<?= base_url('parent-paymentInfo-tuituin/'. esc($students->user_id)); ?>'"
              style="width: 100%; padding: 15px; background: #2196F3; color: white; border: none; border-radius: 8px; margin-bottom: 15px; cursor: pointer;">
              Pay Tuition
            </button>
          </div>

          

          <table id="paymentHistoryTable" class="table table-striped table-hover table-bordered shadow-sm w-100">
            <thead class="primary-table-header">
              <tr>
                <th class="text-start">#</th>
                <th class="text-start"><i class="fas fa-calendar-alt me-1"></i> Payment Date</th>
                <th class="text-start"><i class="fas fa-child me-1"></i> Student Name</th>
                <th class="text-start"><i class="fas fa-child me-1"></i> Fee type</th>
                <th class="text-start"><i class="fas fa-credit-card me-1"></i> Payment Type</th>
                <th class="text-start"><i class="fas fa-money-bill-wave me-1"></i> Amount Paid (₱)</th>
                <th class="text-start"><i class="fas fa-money-bill-wave me-1"></i> Receipt</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($history)): ?>
              <?php $i = 1; foreach ($history as $row): ?>
                <?php 
                    // Map plan_id to fee type
                    $feeType = '';
                    switch($row['plan_id'] ?? '') {
                        case 2:
                            $feeType = 'Registration Fee';
                            break;
                        case 3:
                            $feeType = 'Miscellaneous Fee';
                            break;
                        case 4:
                            $feeType = 'Tuition Fee';
                            break;
                        default:
                            $feeType = 'Other';
                    }
                ?>
              <tr class="align-middle">
                <td class="text-start fw-bold"><?= $i++; ?></td>
                <td class="text-start"><?= date('M d, Y', strtotime($row['payment_date'])); ?></td>
                <td class="text-start fw-semibold "><?= esc($row['full_name']); ?></td>
                <td class="text-start fw-semibold"><?= esc($feeType); ?></td>
                <td class="text-start">
                  <span class="badge bg-info text-dark">
                    <i class="fas fa-tag me-1"></i> <?= esc($row['payment_method']); ?>
                  </span>
                </td>
                <td class="text-start fw-bold text-success">₱<?= number_format($row['amount_paid'], 2); ?></td>
               <td class="text-center fw-semibold">
                  <a href="<?= base_url('/guardian-report/'.esc($row['payment_id'])); ?>" 
                    class="btn btn-primary btn-sm" 
                    target="_blank">
                      View Receipt
                  </a>

                </td>


              </tr>
              <?php endforeach; ?>
              <?php else: ?>
              <tr>
                <td colspan="6" class="text-start text-muted py-4">
                  <i class="fas fa-inbox fa-2x mb-2"></i><br>
                  No payment history found.
                </td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        
      </main>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="<?= base_url('dist/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/user.js') ?>"></script>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- ✅ DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

  <!-- ✅ Initialize DataTable -->
<script>
$(document).ready(function () {
  var table = $('#paymentHistoryTable').DataTable({
    "ordering": false, // keep your original order
    "columnDefs": [
      { "orderable": false, "targets": 0 } // disable sorting for #
    ]
  });

  // Reverse numbering
  table.on('draw.dt', function () {
    var pageInfo = table.page.info();
    var totalRows = pageInfo.recordsDisplay;
    table.column(0, { page: 'current' }).nodes().each(function (cell, i) {
      cell.innerHTML = totalRows - i - pageInfo.start;
    });
  }).draw();
});
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
